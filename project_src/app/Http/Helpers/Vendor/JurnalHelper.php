<?php

namespace App\Http\Helpers\Vendor;

use App\Http\Helpers\CurlHelper;
use App\Http\Helpers\ErrorHelper;
use App\Http\Helpers\GeneralHelper;
use App\Http\Helpers\PosHelper;
use App\Models\BusinessJurnal;
use App\Models\BusinessJurnalEntity;
use App\Models\JurnalLog;
use App\Models\PosSalesTrxDetail;
use App\Models\PosSalesTrxHead;
use Illuminate\Support\Facades\Config;

class JurnalHelper
{
    private static function get_api_url() {
        return Config::get('accounting.jurnal.api_url')
            . Config::get('accounting.jurnal.oauth2_authorization_path');
    }

    private static function get_sales_invoice_endpoint() {
        return self::get_api_url() . Config::get('accounting.jurnal.endpoint.sales_invoice');
    }

    private static function get_customer_endpoint() {
        return self::get_api_url() . Config::get('accounting.jurnal.endpoint.customer');
    }

    private static function get_product_endpoint() {
        return self::get_api_url() . Config::get('accounting.jurnal.endpoint.product');
    }

    private static function get_entity_endpoint($entity) {
        return self::get_api_url() . Config::get('accounting.jurnal.endpoint.' . $entity);
    }

    private static function get_success_http_response_codes() {
        return Config::get('accounting.jurnal.http_success_response_codes');
    }

    private static function is_request_success($http_status) {
        return in_array($http_status, self::get_success_http_response_codes());
    }

    private static function get_authorization_bearer(BusinessJurnal $business_jurnal) {
        return 'Authorization: bearer ' . $business_jurnal->access_token;
    }

    private static function get_access_token_query_parameter(BusinessJurnal $business_jurnal) {
        return ['access_token' => $business_jurnal->access_token];
    }

    public static function is_token_exist_in_another_business($business_id, $access_token) {
        $business_jurnals = BusinessJurnal::where([
            ['business_id', '!=', $business_id],
            ['access_token', '=', $access_token]
        ])->get();
        return !$business_jurnals->isEmpty();
    }

    public static function get_business_jurnal($business_id) {
        return BusinessJurnal::where('business_id', $business_id)->first();
    }

    public static function delete_business_jurnal($business_id) {
        $business_jurnal = JurnalHelper::get_business_jurnal($business_id);
        if (!empty($business_jurnal)) {
            $business_jurnal->delete();
        }
    }

    public static function get_or_create_business_jurnal($business_id, $access_token) {
        $business_jurnal = BusinessJurnal::where([
            ['business_id', '=', $business_id],
            ['access_token', '=', $access_token]
        ])->first();
        if (!empty($business_jurnal)) {
            return;
        }
        $business_jurnal = JurnalHelper::get_business_jurnal($business_id);
        if (empty($business_jurnal)) {
            $business_jurnal = new BusinessJurnal;
            $business_jurnal->business_id = $business_id;
        }
        $business_jurnal->access_token = $access_token;
        $business_jurnal->save();
    }

    private static function get_entity_name($entity) {
        return Config::get('accounting.jurnal.mapper.' . $entity . '.entity_name');
    }

    private static function get_entity_related_table_name($entity) {
        return Config::get('accounting.jurnal.mapper.' . $entity . '.related_table_name');
    }

    private static function get_entity_if_empty_related_table_name($entity) {
        return Config::get('accounting.jurnal.mapper.' . $entity . '.if_empty_related_table_name');
    }

    private static function create_jurnal_log(BusinessJurnal $business_jurnal, $business_jurnal_entity) {
        $jurnal_log = new JurnalLog;
        $jurnal_log->business_id = $business_jurnal->business_id;
        $jurnal_log->business_jurnal_id = $business_jurnal->business_jurnal_id;
        $jurnal_log->business_jurnal_entity_id = $business_jurnal_entity->business_jurnal_entity_id;
        $jurnal_log->endpoint = Config::get('accounting.jurnal.endpoint.' . $business_jurnal_entity->entity_name);
        $jurnal_log->save();
        return $jurnal_log;
    }

    private static function log_jurnal_response($jurnal_log, $http_status, $response) {
        $jurnal_log->http_status = $http_status;
        $jurnal_log->save();

        if (!self::is_request_success($http_status)) {
            ErrorHelper::function_log('log_jurnal_response', 'MCAPI0002', $response);
        }
    }

    private static function post_request($business_jurnal_entity, $params) {
        if ($business_jurnal_entity->entity_name == self::get_entity_name('customer')) {
            $function = function() {
                return self::get_customer_endpoint();
            };
        } else if ($business_jurnal_entity->entity_name == self::get_entity_name('product')) {
            $function = function() {
                return self::get_product_endpoint();
            };
        } else if ($business_jurnal_entity->entity_name == self::get_entity_name('sales_invoice')) {
            $function = function() {
                return self::get_sales_invoice_endpoint();
            };
        }

        if (!is_callable($function)) {
            return;
        }

        $jurnal_log = self::create_jurnal_log($business_jurnal_entity->business_jurnal, $business_jurnal_entity);
        $http_status = 0;

        $result = CurlHelper::post_json(
            array(self::get_authorization_bearer($business_jurnal_entity->business_jurnal)),
            $function(),
            $params,
            $http_status
        );

        self::log_jurnal_response($jurnal_log, $http_status, $result);

        return $result;
    }

    private static function delete_request($business_jurnal_entity, $id) {
        if (empty($id)) {
            return;
        }

        if ($business_jurnal_entity->entity_name == self::get_entity_name('customer')) {
            $function = function() use($id) {
                return self::get_customer_endpoint() . '/' . $id;
            };
        } else if ($business_jurnal_entity->entity_name == self::get_entity_name('product')) {
            $function = function() use($id) {
                return self::get_product_endpoint() . '/' . $id;
            };
        } else if ($business_jurnal_entity->entity_name == self::get_entity_name('sales_invoice')) {
            $function = function() use($id) {
                return self::get_sales_invoice_endpoint() . '/' . $id;
            };
        }

        if (!is_callable($function)) {
            return;
        }

        $jurnal_log = self::create_jurnal_log($business_jurnal_entity->business_jurnal, $business_jurnal_entity);
        $http_status = 0;

        $result = CurlHelper::delete(
            array(self::get_authorization_bearer($business_jurnal_entity->business_jurnal)),
            $function(),
            array(),
            $http_status
        );

        self::log_jurnal_response($jurnal_log, $http_status, $result);

        return $result;
    }

    public static function get_customer_list(BusinessJurnal $business_jurnal) {
        return CurlHelper::get(
            self::get_customer_endpoint(),
            self::get_access_token_query_parameter($business_jurnal)
        );
    }

    public static function get_product_list(BusinessJurnal $business_jurnal) {
        return CurlHelper::get(
            self::get_product_endpoint(),
            self::get_access_token_query_parameter($business_jurnal)
        );
    }

    public static function get_sales_invoice_list(BusinessJurnal $business_jurnal) {
        return CurlHelper::get(
            self::get_sales_invoice_endpoint(),
            self::get_access_token_query_parameter($business_jurnal)
        );
    }

    public static function get_customer_entity_id($user, $business_jurnal_entity) {
        $customers = self::get_customer_list($business_jurnal_entity->business_jurnal);
        if (!empty($customers->customers)) {
            foreach ($customers->customers as $customer) {
                if (!empty($user)) {
                    if (!empty($user->drv_primary_phone)) {
                        if (GeneralHelper::are_parsed_phones_equal($customer->phone, $user->drv_primary_phone)) {
                            return $customer->id;
                        } else if (GeneralHelper::are_parsed_phones_equal($customer->mobile, $user->drv_primary_phone)) {
                            return $customer->id;
                        }
                    } else if (!empty($user->drv_primary_email)) {
                        if (GeneralHelper::are_parsed_emails_equal($customer->email, $user->drv_primary_email)) {
                            return $customer->id;
                        }
                    } else if ($customer->custom_id == $user->user_id) {
                        return $customer->id;
                    }
                } else if ($customer->custom_id == $business_jurnal_entity->related_table_id) {
                    return $customer->id;
                }
            }
        }
        return NULL;
    }

    public static function add_customer_entity(BusinessJurnalEntity $business_jurnal_entity, $user, $guest_code = '') {
        if (!empty($user)) {
            $customer = array(
                'first_name' => $user->name,
                'display_name' => $user->name . ' ' . $user->user_code,
                'custom_id' => $user->user_id
            );

            if (!empty($user->drv_primary_phone)) {
                $customer['phone'] = $user->drv_primary_phone;
                $customer['mobile'] = $user->drv_primary_phone;
            } else if (!empty($user->drv_primary_email)) {
                $customer['email'] = $user->drv_primary_email;
            }
        } else {
            $customer = array(
                'first_name' => $guest_code,
                'display_name' => $guest_code,
                'custom_id' => $guest_code
            );
        }

        $result = self::post_request($business_jurnal_entity, array('customer' => $customer));

        if (!empty($result->customer)) {
            $result->customer->id;
        }
        return NULL;
    }

    public static function get_product_entity_id(PosSalesTrxDetail $pos_sales_trx_detail, BusinessJurnal $business_jurnal) {
        $products = self::get_product_list($business_jurnal);
        if (!empty($products->products)) {
            foreach ($products->products as $product) {
                if (empty($pos_sales_trx_detail->pos_item_variant_id)) {
                    if ($product->custom_id == 'custom-' . $pos_sales_trx_detail->pos_sales_trx_detail_id) {
                        return $product->id;
                    }
                } else {
                    if ($product->custom_id == $pos_sales_trx_detail->pos_item_variant_id) {
                        return $product->id;
                    }
                }
            }
        }
        return NULL;
    }

    public static function add_product_entity(BusinessJurnalEntity $business_jurnal_entity, PosSalesTrxDetail $pos_sales_trx_detail) {
        $product = array(
            'name' => $pos_sales_trx_detail->item_name . ' ' . $pos_sales_trx_detail->variant_name,
            'sell_price_per_unit' => $pos_sales_trx_detail->variant_price,
            'sku' => $pos_sales_trx_detail->sku,
            'is_sold' => TRUE
        );

        if (!empty($pos_sales_trx_detail->pos_item_variant_id)) {
            $product['custom_id'] = $pos_sales_trx_detail->pos_item_variant_id;
        } else {
            $product['custom_id'] = 'custom-' . $pos_sales_trx_detail->pos_sales_trx_detail_id;
        }

        $result = self::post_request($business_jurnal_entity, array('product' => $product));

        if (!empty($result->product)) {
            $result->product->id;
        }
        return NULL;
    }

    public static function get_sales_invoice_entity_id(PosSalesTrxHead $pos_sales_trx_head, BusinessJurnal $business_jurnal) {
        $sales_invoices = self::get_sales_invoice_list($business_jurnal);
        if (!empty($sales_invoices->sales_invoices)) {
            foreach ($sales_invoices->sales_invoices as $sales_invoice) {
                if ($sales_invoice->custom_id == $pos_sales_trx_head->pos_sales_trx_head_id) {
                    return $sales_invoice->id;
                } else if ($sales_invoice->reference_no == PosHelper::get_cashier_trx_reference_id($pos_sales_trx_head)) {
                    return $sales_invoice->id;
                } else if ($sales_invoice->transaction_no == $pos_sales_trx_head->trx_id) {
                    return $sales_invoice->id;
                }
            }
        }
        return NULL;
    }

    public static function add_sales_invoice_entity(BusinessJurnalEntity $business_jurnal_entity, PosSalesTrxHead $pos_sales_trx_head) {
        $user = $pos_sales_trx_head->user;
        if (!empty($user)) {
            $customer_entity_id = self::get_entity_id(
                $business_jurnal_entity->business_jurnal,
                Config::get('accounting.jurnal.entity.customer'),
                $pos_sales_trx_head->user_id,
                $user
            );
        } else {
            $customer_entity_id = self::get_entity_id(
                $business_jurnal_entity->business_jurnal,
                Config::get('accounting.jurnal.entity.customer'),
                $pos_sales_trx_head->user_id,
                $user,
                'Guest-' . PosHelper::get_cashier_trx_reference_id($pos_sales_trx_head)
            );
        }

        if (empty($customer_entity_id)) {
            PosHelper::on_pos_sales_trx_head_success($pos_sales_trx_head, 5);
            exit;
        }

        $transaction_lines_attributes = array();

        $pos_sales_trx_details = $pos_sales_trx_head->normal_pos_sales_trx_details;
        if (!$pos_sales_trx_details->isEmpty()) {
            foreach ($pos_sales_trx_details as $pos_sales_trx_detail) {
                if (!empty($pos_sales_trx_detail->pos_item_variant_id)) {
                    $product_entity_id = self::get_entity_id(
                        $business_jurnal_entity->business_jurnal,
                        Config::get('accounting.jurnal.entity.product'),
                        $pos_sales_trx_detail->pos_item_variant_id,
                        $pos_sales_trx_detail
                    );
                } else {
                    $product_entity_id = self::get_entity_id(
                        $business_jurnal_entity->business_jurnal,
                        Config::get('accounting.jurnal.entity.product'),
                        $pos_sales_trx_detail->pos_sales_trx_detail_id,
                        $pos_sales_trx_detail
                    );
                }
                array_push($transaction_lines_attributes, array(
                    'quantity' => $pos_sales_trx_detail->qty,
                    'rate' => $pos_sales_trx_detail->variant_price,
                    'product_id' => $product_entity_id
                ));
                if (empty($product_entity_id)) {
                    PosHelper::on_pos_sales_trx_head_success($pos_sales_trx_head, 5);
                    exit;
                }
            }
        }

        $sales_invoice = array(
            "sales_invoice" => [
                "transaction_date" => $pos_sales_trx_head->trx_date,
                "transaction_lines_attributes" => $transaction_lines_attributes,
                "reference_no" => PosHelper::get_cashier_trx_reference_id($pos_sales_trx_head),
                "discount_unit" => $pos_sales_trx_head->discount_value,
                "discount_type_name" => Config::get('accounting.jurnal.discount_type.value'),
                "person_id" => $customer_entity_id,
                "transaction_no" => $pos_sales_trx_head->trx_id,
                "custom_id" => $pos_sales_trx_head->pos_sales_trx_head_id,
                "source" => "GD Business",
                "use_tax_inclusive" => false
            ]
        );

        $result = self::post_request($business_jurnal_entity, $sales_invoice);

        if (!empty($result->sales_invoice)) {
            return $result->sales_invoice->id;
        }
        return NULL;
    }

    private static function update_entity_id(&$business_jurnal_entity, $related_table_model, $entity, $custom_code = '') {
        if ($entity == Config::get('accounting.jurnal.entity.customer')) {
            $entity_id = self::get_customer_entity_id($related_table_model, $business_jurnal_entity);
            if (empty($entity_id)) {
                $entity_id = self::add_customer_entity($business_jurnal_entity, $related_table_model, $custom_code);
            }
        } else if ($entity == Config::get('accounting.jurnal.entity.product')) {
            $entity_id = self::get_product_entity_id($related_table_model, $business_jurnal_entity->business_jurnal);
            if (empty($entity_id)) {
                $entity_id = self::add_product_entity($business_jurnal_entity, $related_table_model);
            }
            if (!empty($related_table_model->pos_item_variant_id)) {
                $business_jurnal_entity->related_table_id = $related_table_model->pos_item_variant_id;
                $business_jurnal_entity->save();
            } else {
                $business_jurnal_entity->related_table_id = 'custom-' . $related_table_model->pos_sales_trx_detail_id;
                $business_jurnal_entity->save();
            }
        } else if ($entity == Config::get('accounting.jurnal.entity.sales_invoice')) {
            $entity_id = self::get_sales_invoice_entity_id($related_table_model, $business_jurnal_entity->business_jurnal);
            if (empty($entity_id)) {
                $entity_id = self::add_sales_invoice_entity($business_jurnal_entity, $related_table_model);
            }
        }
        if (!empty($entity_id)) {
            $business_jurnal_entity->entity_id = $entity_id;
            $business_jurnal_entity->save();
        }
    }

    private static function get_business_jurnal_entity(BusinessJurnal &$business_jurnal, $entity, $related_table_id) {
        $where_parameters = [
            ['business_id', '=', $business_jurnal->business_id],
            ['business_jurnal_id', '=', $business_jurnal->business_jurnal_id],
            ['related_table_name', '=', self::get_entity_related_table_name($entity)],
            ['related_table_id', '=', $related_table_id],
            ['entity_name', '=', self::get_entity_name($entity)],
        ];

        if ($entity == Config::get('accounting.jurnal.entity.product') && empty($related_table_id)) {
            $where_parameters['related_table_name'] = self::get_entity_if_empty_related_table_name($entity);
        }

        return BusinessJurnalEntity::where($where_parameters)->first();
    }

    private static function get_entity_id(BusinessJurnal &$business_jurnal, $entity, $related_table_id, $related_table_model, $custom_code = '') {
        if ($entity == Config::get('accounting.jurnal.entity.customer') && empty($related_table_id)) {
            $business_jurnal_entity = self::get_business_jurnal_entity($business_jurnal, $entity, $custom_code);
        } else {
            $business_jurnal_entity = self::get_business_jurnal_entity($business_jurnal, $entity, $related_table_id);
        }

        if (empty($business_jurnal_entity)) {
            $business_jurnal_entity = new BusinessJurnalEntity;
            $business_jurnal_entity->business_id = $business_jurnal->business_id;
            $business_jurnal_entity->business_jurnal_id = $business_jurnal->business_jurnal_id;
            $business_jurnal_entity->related_table_name = self::get_entity_related_table_name($entity);
            if ($entity == Config::get('accounting.jurnal.entity.product') && empty($related_table_id)) {
                $business_jurnal_entity->related_table_name = self::get_entity_if_empty_related_table_name($entity);
            }
            if ($entity == Config::get('accounting.jurnal.entity.customer') && empty($related_table_id)) {
                $business_jurnal_entity->related_table_id = $custom_code;
            } else {
                $business_jurnal_entity->related_table_id = $related_table_id;
            }
            $business_jurnal_entity->entity_name = self::get_entity_name($entity);
            $business_jurnal_entity->save();

            self::update_entity_id($business_jurnal_entity, $related_table_model, $entity, $custom_code);
        } else if (empty($business_jurnal_entity->entity_id)) {
            self::update_entity_id($business_jurnal_entity, $related_table_model, $entity, $custom_code);
        }
        return $business_jurnal_entity->entity_id;
    }

    public static function sync_pos_sales_trx_head($pos_sales_trx_head) {
        $business_jurnal = $pos_sales_trx_head->business_jurnal;
        if (empty($business_jurnal)) {
            return;
        }

        self::get_entity_id(
            $business_jurnal,
            Config::get('accounting.jurnal.entity.sales_invoice'),
            $pos_sales_trx_head->pos_sales_trx_head_id,
            $pos_sales_trx_head
        );
    }

    public static function delete_sales_invoice_entity($pos_sales_trx_head) {
        if (empty($pos_sales_trx_head->business_jurnal)) {
            return;
        }
        $business_jurnal_entity = self::get_business_jurnal_entity(
            $pos_sales_trx_head->business_jurnal,
            Config::get('accounting.jurnal.entity.sales_invoice'),
            $pos_sales_trx_head->pos_sales_trx_head_id
        );
        self::delete_request($business_jurnal_entity, $business_jurnal_entity->entity_id);
        $business_jurnal_entity->delete();
    }

    public static function response_code_handler($http_status) {
        if (in_array($http_status, array(200, 201, 204))) {

        }
    }

    // MONITORING
    public static function check_jurnal_log() {
        return app('db')->connection(config('database.monitoring'))->select('
            SELECT 
              jl.jurnal_log_id
            FROM jurnal_log jl
            LEFT JOIN business_jurnal_entity bje ON bje.business_jurnal_entity_id = jl.business_jurnal_entity_id
            LEFT JOIN business_jurnal bj ON bj.business_jurnal_id = bje.business_jurnal_id
            WHERE
              jl.http_status NOT IN(200, 201, 204)
              AND bje.entity_id IS NULL
              AND jl.deleted_at IS NULL
              AND bje.deleted_at IS NULL
              AND bj.deleted_at IS NULL
        ');
    }
}