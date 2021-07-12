<?php

namespace App\Http\Helpers;

/*
 * Helper functions for building a DataTables server-side processing SQL query
 *
 * The static functions in this class are just helper functions to help build
 * the SQL used in the DataTables demo server-side processing scripts. These
 * functions obviously do not represent all that can be done with server-side
 * processing, they are intentionally simple to show how it works. More complex
 * server-side processing operations will likely require a custom script.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class SSPHelper
{
    const PGSQL_DRIVER = 'pgsql';
    const MYSQL_DRIVER = 'mysql';

    const IS_NOT_COLUMN_FILTERING = 0;
    const IS_COLUMN_FILTERING = 1;

    /**
     * Create the data output array for the DataTables rows
     *
     * @param array $columns Column information array
     * @param array $data    Data from the SQL get
     * @param bool  $isJoin  Determine the the JOIN/complex query or simple one
     *
     * @return array Formatted data in a row based format
     */

    public function __construct()
    {

    }

    static function words_to_array($words) {
//        $words = preg_replace("/\b\S{1,3}\b/", "", $words);
        return preg_split("/\s+/", $words);
    }

    static function get_pgsql_query($query, $schema) {
        $words = self::words_to_array($query);
        $is_from = 0;
        $is_join = 0;
        foreach($words as $key => $word) {
            if (strcasecmp($word, "from") == 0) {
                $is_from = 1;
            } else if (strcasecmp($word, "join") == 0) {
                $is_join = 1;
            } else if ($is_from == 1) {
                $is_from = 0;
                $words[$key] = $schema . "." . $word;
            } else if ($is_join == 1) {
                $is_join = 0;
                $words[$key] = $schema . "." . $word;
            }
        }
        return implode(" ", $words);
    }

    static function data_output ( $columns, $data, $isJoin = false ) {
        if (is_array($isJoin)) {
            $columns = $columns[0];
        }
        $out = array();

        for ( $i=0, $ien=count($data) ; $i<$ien ; $i++ ) {
            $row = array();

            for ( $j=0, $jen=count($columns) ; $j<$jen ; $j++ ) {
                $column = $columns[$j];

                // Is there a formatter?
                if (isset($column['formatter'])) {
                    $row[$column['as']] = ($isJoin) ? $column['formatter']($data[$i]->{$column['as']}, $data[$i])
                        : $column['formatter']($data[$i]->{$column['db']}, $data[$i]);
                } else {
                    $row[$column['as']] = ($isJoin) ? $data[$i]->{$columns[$j]['as']} : $data[$i]->{$columns[$j]['db']};
                }
            }

            $out[] = $row;
        }

        return $out;
    }


    /**
     * Paging
     *
     * Construct the LIMIT clause for server-side processing SQL query
     *
     *  @param  array $request Data sent to server by DataTables
     *  @return string SQL limit clause
     */
    static function limit ( $request )
    {
        $limit = '';

        if ( isset($request['start']) && $request['length'] != -1 ) {
            $limit = "LIMIT " . intval($request['length']) . " OFFSET " . intval($request['start']) ;
        }

        return $limit;
    }


    /**
     * Ordering
     *
     * Construct the ORDER BY clause for server-side processing SQL query
     *
     *  @param  array $request Data sent to server by DataTables
     *  @param  array $columns Column information array
     *  @param bool  $isJoin  Determine the the JOIN/complex query or simple one
     *
     *  @return string SQL order by clause
     */
    static function order ( $request, $columns, $isJoin = false, &$bindings ) {
        if (!is_array($isJoin)) {
            $order = '';

            if ( isset($request['order']) && count($request['order']) ) {
                $orderBy = array();
                $dtColumns = SSPHelper::pluck( $columns, 'as' );

                for ( $i=0, $ien=count($request['order']) ; $i<$ien ; $i++ ) {
                    // Convert the column index into the column data property
                    $columnIdx = intval($request['order'][$i]['column']);
                    $requestColumn = $request['columns'][$columnIdx];

                    $columnIdx = array_search( $requestColumn['data'], $dtColumns );
                    $column = $columns[ $columnIdx ];

                    if ( $requestColumn['orderable'] == 'true' ) {
                        $dir = $request['order'][$i]['dir'] === 'asc' ?
                            'ASC' :
                            'DESC';
//                    $column_name = $column['db'];
                        $column_name = SSPHelper::get_column_name($column['db'], $bindings);
                        $prefix = substr(strtolower($column['db']), 0, 4);
                        if($prefix == "max(" || $prefix == "sum(")
                        {
                            $column_name = substr($column['db'], 4, strlen($column['db'])-5);
                        }
                        else if(strpos(strtolower($column['db']), "group_concat(") !== FALSE && strpos(strtolower($column['db']), "group_concat(") == 0)
                        {
                            $column_name = substr($column_name, 13, strlen($column_name)-14);
                            $validator = "distinct ";
                            if(strpos(strtolower($column_name), $validator) !== FALSE)
                                $column_name = substr($column_name, strlen($validator));

                            $validator = " separator \" \"";
                            if(strpos(strtolower($column_name), $validator) !== FALSE)
                                $column_name = substr($column_name, 0, strlen($column_name)-strlen($validator));
                        }
                        $orderBy[] = ($isJoin) ? $column_name.' '.$dir : '`'.$column_name.'` '.$dir;
                    }
                }

                $order = 'ORDER BY '.implode(', ', $orderBy);
            }

            return $order;
        } else {
            $order = array();

            foreach ($columns as $key => $value) {
                if ( isset($request['order']) && count($request['order']) ) {
                    $orderBy = array();
                    $dtColumns = SSPHelper::pluck( $value, 'as' );

                    for ( $i=0, $ien=count($request['order']) ; $i<$ien ; $i++ ) {
                        // Convert the column index into the column data property
                        $columnIdx = intval($request['order'][$i]['column']);
                        $requestColumn = $request['columns'][$columnIdx];

                        $columnIdx = array_search( $requestColumn['data'], $dtColumns );
                        $column = $value[ $columnIdx ];

                        if ( $requestColumn['orderable'] == 'true' ) {
                            $dir = $request['order'][$i]['dir'] === 'asc' ?
                                'ASC' :
                                'DESC';
//                    $column_name = $column['db'];
                            $column_name = SSPHelper::get_column_name($column['as'], $bindings);
                            $prefix = substr(strtolower($column['as']), 0, 4);
                            if($prefix == "max(" || $prefix == "sum(")
                            {
                                $column_name = substr($column['as'], 4, strlen($column['as'])-5);
                            }
                            else if(
                                strpos(strtolower($column['as']), "group_concat(") !== FALSE
                                && strpos(strtolower($column['as']), "group_concat(") == 0
                            )
                            {
                                $column_name = substr($column_name, 13, strlen($column_name)-14);
                                $validator = "distinct ";
                                if(strpos(strtolower($column_name), $validator) !== FALSE)
                                    $column_name = substr($column_name, strlen($validator));

                                $validator = " separator \" \"";
                                if(strpos(strtolower($column_name), $validator) !== FALSE)
                                    $column_name = substr($column_name, 0, strlen($column_name)-strlen($validator));
                            }
                            $orderBy[] = ($isJoin[$key]) ? $column_name.' '.$dir : '`'.$column_name.'` '.$dir;
                        }
                    }

                    $order = 'ORDER BY '.implode(', ', $orderBy);
                }
                break;
            }
            return $order;
        }
    }

    static function get_column_name($column_name, &$bindings) {
        $words = explode(' ', $column_name);
        foreach ($words as $key => $value) {
            if (substr($value, 0, 1) == ':') {
                $param = trim(substr($value, 1));
                $array_bind = ArrayHelper::set_array_bind_key($bindings, $param, $bindings[$param]);
                $words[$key] = $array_bind['array_bind_key'];
            }
        }
        $column_name = implode(' ', $words);
        return $column_name;
    }

    static function get_column_prefix($column) {
        return substr(strtolower(trim($column)), 0, 4);
    }

    static function is_having_statement($prefix, $column) {

        $column_db_statement = trim($column['db']);

        return $prefix == "max("
            || $prefix == "sum("
            || substr(strtolower($column_db_statement), 0, 6) == "count("
            || (strpos($column_db_statement, "group_concat(")!==FALSE && strpos($column_db_statement, "group_concat(")==0)
            || (strpos($column_db_statement, "IFNULL(")!==FALSE && strpos($column_db_statement, "IFNULL(")==0)
            || (strpos($column_db_statement, "IFNULL (")!==FALSE && strpos($column_db_statement, "IFNULL (")==0)
            || (strpos($column_db_statement, "IF (")!==FALSE && strpos($column_db_statement, "IF (")==0)
            || (strpos($column_db_statement, "IF(")!==FALSE && strpos($column_db_statement, "IF(")==0);
    }

    static function push_where_query_string($column, &$bindings, $isJoin, $search_string, $int_operator, &$whereSearch, &$havingSearch, $column_filtering = 0, $columns_using_having_statement = 0) {

        $prefix = self::get_column_prefix($column['db']);

        $is_having_statement = self::is_having_statement($prefix, $column);

        if (!empty($columns_using_having_statement) || !empty($is_having_statement)) {
            $column_name = SSPHelper::get_column_name($column['as'], $bindings);
        } else {
            $column_name = SSPHelper::get_column_name($column['db'], $bindings);
        }

        if ($int_operator == 1) {
            if (!ctype_digit($search_string)) {
                $column_field = ArrayHelper::set_array_bind_key($bindings, $column['field'], '%'.$search_string.'%');
            }
        } else {
            $column_field = ArrayHelper::set_array_bind_key($bindings, $column['field'], '%'.$search_string.'%');
        }

        if ($int_operator == 1) {
            if (ctype_digit($search_string)) {
                $search_query_string = ($isJoin) ? $column_name." = $search_string" : "`".$column_name."` = $search_string";
            } else {
                $search_query_string = ($isJoin) ? $column_name." LIKE ".$column_field['array_bind_key'] : "`"
                    .$column_name."` LIKE ".$column_field['array_bind_key'];
            }
        } else {
            $search_query_string = ($isJoin) ? $column_name." LIKE ".$column_field['array_bind_key'] : "`".$column_name
                ."` LIKE ".$column_field['array_bind_key'];
        }

        if (!empty($columns_using_having_statement) || !empty($is_having_statement)) {
            $havingSearch[] = $search_query_string;
        } else {
            $whereSearch[] = $search_query_string;

            $column_name = SSPHelper::get_column_name($column['as'], $bindings);

            if ($int_operator == 1) {
                if (!ctype_digit($search_string)) {
                    $column_field = ArrayHelper::set_array_bind_key($bindings, $column['field'], '%'.$search_string.'%');
                }
            } else {
                $column_field = ArrayHelper::set_array_bind_key($bindings, $column['field'], '%'.$search_string.'%');
            }

            if ($int_operator == 1) {
                if (ctype_digit($search_string)) {
                    $search_query_string = ($isJoin) ? $column_name." = $search_string" : "`".$column_name."` = $search_string";
                } else {
                    $search_query_string = ($isJoin) ? $column_name." LIKE ".$column_field['array_bind_key'] : "`"
                        .$column_name."` LIKE ".$column_field['array_bind_key'];
                }
            } else {
                $search_query_string = ($isJoin) ? $column_name." LIKE ".$column_field['array_bind_key'] : "`".$column_name
                    ."` LIKE ".$column_field['array_bind_key'];
            }

            $havingSearch[] = $search_query_string;
        }
    }

    static function implode_where_query_string($globalSearch, $columnSearch, &$where) {
        if ( count( $globalSearch ) ) {
            $where = '('.implode(' OR ', $globalSearch).')';
        }

        if ( count( $columnSearch ) ) {
            $where = $where === '' ?
                implode(' AND ', $columnSearch) :
                $where .' AND '. implode(' AND ', $columnSearch);
        }

        if ( $where !== '' ) {
            $where = 'WHERE '.$where;
        }
    }

    static function implode_having_query_string($havingGlobalSearch, $havingColumnSearch, &$having) {
        if ( count( $havingGlobalSearch ) ) {
            $having = '('.implode(' OR ', $havingGlobalSearch).')';
        }

        if ( count( $havingColumnSearch ) ) {
            $having = $having === '' ?
                implode(' AND ', $havingColumnSearch) :
                $having .' AND '. implode(' AND ', $havingColumnSearch);
        }

        if ( $having !== '' ) {
            $having = 'HAVING '.$having;
        }
    }

    public static function columns_using_having_statement($request, $columns, $dtColumns) {

        $is_having_statement = 0;

        for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
            $requestColumn = $request['columns'][$i];
            $columnIdx = array_search( $requestColumn['data'], $dtColumns );
            $column = $columns[ $columnIdx ];

            if ( $requestColumn['searchable'] == 'true' ) {
                $prefix = self::get_column_prefix($column['db']);

                $is_having_statement = self::is_having_statement($prefix, $column);
            }

            if ($is_having_statement) {
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * Searching / Filtering
     *
     * Construct the WHERE clause for server-side processing SQL query.
     *
     * NOTE this does not match the built-in DataTables filtering which does it
     * word by word on any field. It's possible to do here performance on large
     * databases would be very poor
     *
     *  @param  array $request Data sent to server by DataTables
     *  @param  array $columns Column information array
     *  @param  array $bindings Array of values for PDO bindings, used in the sql_exec() function
     *  @param  bool  $isJoin  Determine the the JOIN/complex query or simple one
     *
     *  @return array SQL where clause
     */
    static function filter ( $request, $columns, &$bindings, $isJoin = false, $int_operator = 0 ) {
        if (!is_array($isJoin)) {
            $globalSearch = array();
            $columnSearch = array();
            $havingGlobalSearch = array();
            $havingColumnSearch = array();
            $dtColumns = SSPHelper::pluck( $columns, 'as' );

            if ( isset($request['search']) && $request['search']['value'] != '' ) {
                $str = $request['search']['value'];

                $columns_using_having_statement = self::columns_using_having_statement($request, $columns, $dtColumns);

                for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
                    $requestColumn = $request['columns'][$i];
                    $columnIdx = array_search( $requestColumn['data'], $dtColumns );
                    $column = $columns[ $columnIdx ];

                    if ( $requestColumn['searchable'] == 'true' ) {
                        self::push_where_query_string(
                            $column,
                            $bindings,
                            $isJoin,
                            $str,
                            $int_operator,
                            $globalSearch,
                            $havingGlobalSearch,
                            SSPHelper::IS_NOT_COLUMN_FILTERING,
                            $columns_using_having_statement
                        );
                    }
                }
            }

            if(isset($request["columns"]))
            {
                // Individual column filtering
                for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
                    $requestColumn = $request['columns'][$i];
                    $columnIdx = array_search( $requestColumn['data'], $dtColumns );
                    $column = $columns[ $columnIdx ];

                    $str = $requestColumn['search']['value'];

                    if ( $requestColumn['searchable'] == 'true' && $str != '' ) {
                        self::push_where_query_string(
                            $column,
                            $bindings,
                            $isJoin,
                            $str,
                            $int_operator,
                            $columnSearch,
                            $havingColumnSearch,
                            SSPHelper::IS_COLUMN_FILTERING
                        );
                    }
                }
            }

            // Combine the filters into a single string
            $where = '';
            $having = '';

            self::implode_where_query_string($globalSearch, $columnSearch, $where);
            self::implode_having_query_string($havingGlobalSearch, $havingColumnSearch, $having);

            return array(
                'having' => $having,
                'where' => $where
            );
        } else {
            $where = array();
            $having = array();

            foreach ($columns as $key => $value) {
                $globalSearch = array();
                $columnSearch = array();
                $havingGlobalSearch = array();
                $havingColumnSearch = array();
                $dtColumns = SSPHelper::pluck( $value, 'as' );

                if ( isset($request['search']) && $request['search']['value'] != '' ) {
                    $str = $request['search']['value'];

                    $columns_using_having_statement = self::columns_using_having_statement($request, $value, $dtColumns);

                    for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
                        $requestColumn = $request['columns'][$i];
                        $columnIdx = array_search( $requestColumn['data'], $dtColumns );
                        $column = $value[ $columnIdx ];

                        if ( $requestColumn['searchable'] == 'true' ) {
                            self::push_where_query_string(
                                $column,
                                $bindings,
                                $isJoin[$key],
                                $str,
                                $int_operator,
                                $globalSearch,
                                $havingGlobalSearch,
                                SSPHelper::IS_NOT_COLUMN_FILTERING,
                                $columns_using_having_statement
                            );

//                            if (!empty($havingGlobalSearch) && !empty($globalSearch)) {
//                                $havingGlobalSearch = array_merge($globalSearch, $havingGlobalSearch);
//                                $globalSearch = [];
//                            }
                        }
                    }
                }

                if (isset($request["columns"])) {
                    // Individual column filtering
                    for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
                        $requestColumn = $request['columns'][$i];
                        $columnIdx = array_search( $requestColumn['data'], $dtColumns );
                        $column = $value[ $columnIdx ];

                        $str = $requestColumn['search']['value'];

                        if ( $requestColumn['searchable'] == 'true' && $str != '' ) {
                            self::push_where_query_string(
                                $column,
                                $bindings,
                                $isJoin[$key],
                                $str,
                                $int_operator,
                                $columnSearch,
                                $havingColumnSearch,
                                SSPHelper::IS_COLUMN_FILTERING
                            );
                        }
                    }
                }

                // Combine the filters into a single string
                $where_temp = '';
                $having_temp = '';

                self::implode_where_query_string($globalSearch, $columnSearch, $where_temp);
                self::implode_having_query_string($havingGlobalSearch, $havingColumnSearch, $having_temp);

                array_push($where, $where_temp);
                array_push($having, $having_temp);
            }

            return array(
                'where' => $where,
                'having' => $having
            );
        }
    }


    /**
     * Perform the SQL queries needed for an server-side processing requested,
     * utilising the helper functions of this class, limit(), order() and
     * filter() among others. The returned array is ready to be encoded as JSON
     * in response to an SSP request, or can be modified if needed before
     * sending back to the client.
     *
     *  @param  array $request Data sent to server by DataTables
     *  @param  array $sql_details SQL connection details - see sql_connect()
     *  @param  string $table SQL table to query
     *  @param  string $primaryKey Primary key of the table
     *  @param  array $columns Column information array
     *  @param  array $joinQuery Join query String
     *  @param  string $extraWhere Where query String
     *
     *  @return array  Server-side processing response array
     *
     */
    static function simple ( $data = array() ) {
        $request = $_POST;
        $connection = !empty($data['connection']) ? $data['connection'] : config('database.default') ;
        $database_config = Config::get('database');
        $driver = $database_config['connections'][$connection]['driver'];
        $schema = '';
        if ($driver == self::PGSQL_DRIVER) {
            $schema = $database_config['connections'][$connection]['schema'];
        }
        $table = !empty($data['table_used']) ? $data['table_used'] : '' ;
        $primaryKey = !empty($data['primary_key']) ? $data['primary_key'] : '' ;
        $columns = !empty($data['array_columns']) ? $data['array_columns'] : '' ;
        $joinQuery = !empty($data['join_query']) ? $data['join_query'] : '' ;
        $extraWhere = !empty($data['where']) ? $data['where'] : '' ;
        $count_where = !empty($data['count_where']) ? $data['count_where'] : '' ;
        $groupBy = !empty($data['group_by']) ? $data['group_by'] : '' ;
        $bindings = !empty($data['bindings']) ? $data['bindings'] : array() ;

        // Build the SQL query string from the request
        $limit = SSPHelper::limit( $request );
        $order = SSPHelper::order( $request, $columns, $joinQuery, $bindings );
        $filter = SSPHelper::filter( $request, $columns, $bindings, $joinQuery, 0);
        $where = GeneralHelper::if_empty($filter['where'], '');
        $having = GeneralHelper::if_empty($filter['having'], '');

        if (!is_array($joinQuery)) {
            // IF Extra where set then set and prepare query
            if ($extraWhere) {
                $extraWhere = ($where) ? ' AND '.$extraWhere : ' WHERE '.$extraWhere;
            }

            $query = "";
            if ($driver == self::MYSQL_DRIVER) {
                $query = " SQL_CALC_FOUND_ROWS";
            } else {
                $table = $schema . '.' . $table;
                $joinQuery = self::get_pgsql_query($joinQuery, $schema);
            }

            // Main query to actually get the data
            if ($joinQuery) {
                $col = SSPHelper::pluck($columns, 'db', $joinQuery, $driver, $schema);

                $query =  "SELECT" . $query . " ".implode(", ", $col)."
                     $joinQuery
                     $where
                     $extraWhere
                     $groupBy
                     $having
                     $order
                     $limit
			    ";
            } else {
                $query =  "SELECT" . $query . " ".implode(", ", SSPHelper::pluck($columns, 'db', false, $driver, $schema))."
                     FROM `$table`
                     $where
                     $extraWhere
                     $groupBy
                     $order
                     $having
                     $limit
                ";
            }

            $data = app('db')->connection($connection)->select($query, $bindings);

            if ($count_where != "") {
                $count_where = " where ".$count_where;
            }

            if ($driver == self::MYSQL_DRIVER) {
                // Data set length after filtering
                $resFilterLength = app('db')->connection($connection)->select('
                    SELECT FOUND_ROWS() AS found_rows
                ');
                $recordsFiltered = $resFilterLength[0]->found_rows;

                $total_length_query = '
                    SELECT COUNT(' . $primaryKey . ') AS total_length
                     FROM ' . $table . ' ' . $count_where . '
                ';

                // Total data set length
                $resTotalLength = app('db')->connection($connection)->select($total_length_query);
                $recordsTotal = $resTotalLength[0]->total_length;
            } else {
                if ($joinQuery) {
                    $resFilterLengthQuery =  "SELECT COUNT(*) AS found_rows
                         $joinQuery
                         $where
                         $extraWhere
                    ";
                    $total_length_query = "
                        SELECT COUNT(*) AS total_length " . $joinQuery . $extraWhere ;
                } else {
                    $resFilterLengthQuery =  "SELECT COUNT(tbl.'" . $primaryKey . "') AS found_rows
                         FROM `$table` tbl
                         $where
                         $extraWhere
                    ";
                    $total_length_query = '
                        SELECT COUNT(tbl."' . $primaryKey . '") AS total_length
                         FROM ' . $table . ' tbl ' . $count_where . '
                    ';
                }

                $resFilterLength = app('db')->connection($connection)->select($resFilterLengthQuery, $bindings);
                $recordsFiltered = $resFilterLength[0]->found_rows;

                // Total data set length
                $resTotalLength = app('db')->connection($connection)->select($total_length_query);
                $recordsTotal = $resTotalLength[0]->total_length;
            }
        } else {
            $query = '';
            $x = 0;
            foreach ($joinQuery as $key => $value) {
                $x++;
                // IF Extra where set then set and prepare query
                if ($extraWhere[$key]) {
                    $extraWhere[$key] = ($where[$key]) ? ' AND '.$extraWhere[$key] : ' WHERE '.$extraWhere[$key];
                }

                if ($driver == self::PGSQL_DRIVER) {
                    $table[$key] = $schema . '.' . $table[$key];
                    $joinQuery[$key] = self::get_pgsql_query($joinQuery[$key], $schema);
                }

                // Main query to actually get the data
                if ($joinQuery[$key]) {
                    $group_by_string = !empty($groupBy[$key])? $groupBy[$key] : '' ;
                    $col = SSPHelper::pluck($columns[$key], 'db', $joinQuery, $driver, $schema);
                    if ($x > 1) {
                        $query .= ' UNION ALL ';
                    }
                    $query .=  'SELECT ' . implode(", ", $col)."
                     $joinQuery[$key]
                     $where[$key]
                     $extraWhere[$key]
                     $group_by_string
                     $having[$key]
                     ";
                } else {
                    $group_by_string = !empty($groupBy[$key])? $groupBy[$key] : '' ;
                    $col = SSPHelper::pluck($columns[$key], 'db', false, $driver, $schema);
                    if ($x > 1) {
                        $query .= ' UNION ALL ';
                    }
                    $query .=  'SELECT ' . implode(", ", $col)."
                     FROM `$table[$key]`
                     $where[$key]
                     $extraWhere[$key]
                     $group_by_string
                     $having[$key]
                     ";
                }
            }

            $found_row_query = '';
            if ($driver == self::MYSQL_DRIVER) {
                $found_row_query = " SQL_CALC_FOUND_ROWS";
            }

            if (!empty($order)) {
                $query = 'SELECT' . $found_row_query . ' * FROM (' . $query . ') a ' . $order .' ' . $limit;
            } else {
                $query = 'SELECT' . $found_row_query . ' * FROM (' . $query . ') a ' . $limit;
            }

            $data = app('db')->connection($connection)->select($query, $bindings);

            if ($driver == self::MYSQL_DRIVER) {
                // Data set length after filtering
                $resFilterLength = app('db')->connection($connection)->select('
                    SELECT FOUND_ROWS() AS found_rows
                ');
                $recordsFiltered = $resFilterLength[0]->found_rows;
            } else {
                $recordsFiltered = count($data);
            }

            $recordsTotal = 0;
            $x = 0;
            if (!empty($count_where)) {
                $query = '';
                foreach ($count_where as $key => $value) {
                    $x++;
                    $count_where[$key] = " where " . $count_where[$key];
                    if ($driver == self::MYSQL_DRIVER) {
                        if ($x > 1) {
                            $query .= ' UNION ';
                        }
                        $query .= 'SELECT DISTINCT ' . $primaryKey[$key] . '
                             FROM ' . $table[$key] . ' ' . $count_where[$key];
//                        $resTotalLength = app('db')->connection($connection)->select('
//                            SELECT COUNT(DISTINCT ' . $primaryKey[$key] . ') AS total_length
//                             FROM ' . $table[$key] . ' ' . $count_where[$key] . '
//                        ');
                    } else {
                        if ($x > 1) {
                            $query .= ' UNION ';
                        }
                        $query .= 'SELECT DISTINCT tbl."' . $primaryKey[$key] . '" AS total_length
                             FROM ' . $table[$key] . ' tbl ' . $count_where[$key];
//                        $resTotalLength = app('db')->connection($connection)->select('
//                            SELECT COUNT(DISTINCT tbl."' . $primaryKey[$key] . '") AS total_length
//                             FROM ' . $table[$key] . ' tbl ' . $count_where[$key] . '
//                        ');
                    }
                }
                $resTotalLength = app('db')->connection($connection)->select($query);
                $recordsTotal += count($resTotalLength);
            }
        }

        /*
         * Output
         */
        $output = array(
            "draw"            => intval( !empty($request['draw']) ? $request['draw'] : 1 ),
//             "query" => $query,
//            "resFilterLengthQuery" => !empty($resFilterLengthQuery) ? $resFilterLengthQuery : "" ,
//            "total_length_query" => !empty($total_length_query) ? $total_length_query : "" ,
//             "where" => $extraWhere,
//             "binding" => $bindings,
            // "order" => $order,
//             "columns" => $request['columns'],
            "recordsTotal"    => intval( $recordsTotal ),
            "recordsFiltered" => intval( $recordsFiltered ),
            "data"            => SSPHelper::data_output( $columns, $data, $joinQuery )
        );
        if (App::environment('local') || App::environment('staging')) {
            $output['query'] = $query;
        }
        return $output;
    }


    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Internal methods
     */

    /**
     * Throw a fatal error.
     *
     * This writes out an error message in a JSON string which DataTables will
     * see and show to the user in the browser.
     *
     * @param  string $msg Message to send to the client
     */
    static function fatal ( $msg )
    {
        echo json_encode( array(
            "error" => $msg
        ) );

        exit(0);
    }

    /**
     * Create a PDO binding key which can be used for escaping variables safely
     * when executing a query with sql_exec()
     *
     * @param  array &$a    Array of bindings
     * @param  *      $val  Value to bind
     * @param  int    $type PDO field type
     * @return string       Bound key to be used in the SQL where this parameter
     *   would be used.
     */
    static function bind ( &$a, $val, $type )
    {
        $key = ':binding_'.count( $a );

        $a[] = array(
            'key' => $key,
            'val' => $val,
            'type' => $type
        );

        return $key;
    }


    /**
     * Pull a particular property from each assoc. array in a numeric array,
     * returning and array of the property values from each item.
     *
     *  @param  array  $a    Array to get data from
     *  @param  string $prop Property to read
     *  @param  bool  $isJoin  Determine the the JOIN/complex query or simple one
     *  @return array        Array of property values
     */
    static function pluck ( $a, $prop, $isJoin = false, $driver = self::MYSQL_DRIVER, $schema = "")
    {
        $out = array();

        for ( $i=0, $len=count($a) ; $i<$len ; $i++ ) {
            $column = $a[$i][$prop];
            if ($driver == self::PGSQL_DRIVER) {
                $column = self::get_pgsql_query($column, $schema);
            }
            $out[] = ($isJoin && isset($a[$i]['as'])) ? $column . ' AS '.$a[$i]['as'] : $column ;
        }

        return $out;
    }
}
