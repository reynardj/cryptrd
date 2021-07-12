<?php

namespace App\Http\Helpers;

use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
//use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
//use Box\Spout\Common\Entity\Row;

class ExcelHelper
{
    const PHPSPREADSHEET_EXCEL_LIBRARY = 'PHPSPREADSHEET';
    const SPROUT_EXCEL_LIBRARY = 'SPROUT';

    public static function create_spreadsheet($excel_library = self::PHPSPREADSHEET_EXCEL_LIBRARY) {
        if ($excel_library == self::PHPSPREADSHEET_EXCEL_LIBRARY) {
            $spreadsheet = new Spreadsheet();
            $spreadsheet->setActiveSheetIndex(0);
            return $spreadsheet;
        } else {
            $writer = WriterFactory::create(Type::XLSX);
            // $writer = WriterEntityFactory::createXLSXWriter();
            // $writer = WriterEntityFactory::createODSWriter();
            // $writer = WriterEntityFactory::createCSVWriter();
            $writer->openToBrowser('test.xlsx');
            return $writer;
        }
    }

    public static function create_excel_report($config) {
        $spreadsheet = self::create_spreadsheet();
        $spreadsheet->getActiveSheet()->setTitle($config->sheet_title);
        $worksheet = self::get_active_sheet($spreadsheet);

        if (!empty($config->start_row)) {
            $date_selection = 'Date Selection: ' . $config->start_date . ' - ' . $config->end_date;
            $filtered_by = 'Filtered By: ' . $config->report_filter_text;
            ExcelHelper::fill_cell($worksheet, 'A1', $date_selection);
            ExcelHelper::fill_cell($worksheet, 'A2', $filtered_by);
        }

        //Loop Heading
        $rowNumberH = $config->start_row;
        $colH = 'A';
        foreach($config->heading as $h){
            ExcelHelper::fill_cell($worksheet, $colH.$rowNumberH, $h);
            $colH++;
        }
        return $spreadsheet;
    }

    public static function get_active_sheet($spreadsheet) {
        $sheet = $spreadsheet->getActiveSheet();
        return $sheet;
    }

    public static function add_filter_row($spreadsheet, $config) {
        if (!empty($config->start_row) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
            $date_selection = ['Date Selection: ' . $_GET['start_date'] . ' - ' . $_GET['end_date']];
            $filtered_by = ['Filtered By: ' . $_GET['grouping_by_text']];
            $spreadsheet->addRow($date_selection);
            $spreadsheet->addRow($filtered_by);
        }
    }

    public static function add_new_sheet($spreadsheet, $config, $i, $excel_library = self::PHPSPREADSHEET_EXCEL_LIBRARY) {

        $worksheet_name = substr($config->sheet_title, 0, 31);

        if ($excel_library == self::PHPSPREADSHEET_EXCEL_LIBRARY) {
            $worksheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet(
                $spreadsheet,
                $worksheet_name
            );

            $spreadsheet->addSheet($worksheet, $i);
            if (!empty($config->start_row) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
                $date_selection = 'Date Selection: ' . $_GET['start_date'] . ' - ' . $_GET['end_date'];
                $filtered_by = 'Filtered By: ' . $_GET['grouping_by_text'];
                ExcelHelper::fill_cell($worksheet, 'A1', $date_selection);
                ExcelHelper::fill_cell($worksheet, 'A2', $filtered_by);
            }

            //Loop Heading
            $rowNumberH = $config->start_row;
            $colH = 'A';
            foreach($config->heading as $h){
                ExcelHelper::fill_cell($worksheet, $colH.$rowNumberH, $h);
                $colH++;
            }
            return $worksheet;
        } else {
            $worksheet = $spreadsheet->addNewSheetAndMakeItCurrent();
            $worksheet->setName($worksheet_name);

            if (!empty($config->start_row) && !empty($_GET['start_date']) && !empty($_GET['end_date'])) {
                $date_selection = ['Date Selection: ' . $_GET['start_date'] . ' - ' . $_GET['end_date']];
                $filtered_by = ['Filtered By: ' . $_GET['grouping_by_text']];
                $spreadsheet->addRow($date_selection);
                $spreadsheet->addRow($filtered_by);
            }

            return $spreadsheet;
        }
    }

    public static function create_sheet($spreadsheet) {
        return $spreadsheet->createSheet();
    }

    public static function set_current_sheet_name($spreadsheet, $worksheet_name) {
        $spreadsheet->getCurrentSheet()->setName($worksheet_name);
    }

    public static function fill_cell($sheet, $cell, $cell_value, $excel_library = self::PHPSPREADSHEET_EXCEL_LIBRARY) {
        if ($excel_library == self::PHPSPREADSHEET_EXCEL_LIBRARY) {
            $sheet->setCellValue($cell, $cell_value);
        } else {
            $values = [$cell_value];
            $sheet->addRow($values);
        }
    }

    public static function get_empty_cells_for_visible_column($column_alphabets, $key) {
        return ArrayHelper::array_of_empty_string(
            ArrayHelper::get_index_prev_key_of_array(
                $column_alphabets,
                $key
            )
        );
    }

    public static function createRowsFromArrayOfRow($sheet, $array) {
        foreach ($array as $row) {
            $values = [$row];
//            $rowFromValues = WriterEntityFactory::createRowFromArray($values);
            $sheet->addRow($values);
        }
    }

    public static function createRowFromArray($spreadsheet, $array) {
        $spreadsheet->addRow($array);
    }

    public static function fill_visible_cell_worksheet($column_array, $column_name, $sheet, &$alphabet, $row, $val) {
        if (in_array($column_name, $column_array)) {
            $sheet->setCellValueExplicit($alphabet++.$row, $val, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        }
    }

    public static function create_xlsx($spreadsheet, $filename) {
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);
        return $writer;
    }

    public static function get_worksheet($inputFileName, $worksheet_index = 0) {
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
        $objReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $objReader->setReadDataOnly(TRUE);

        $objPHPExcel = $objReader->load($inputFileName);
        $worksheet = $objPHPExcel->getSheet($worksheet_index);
//        $worksheet = $objPHPExcel->getActiveSheet();
        return $worksheet;
    }

    public static function get_cell_value($worksheet, $cell_index) {
        return $worksheet->getCell($cell_index)->getValue();
    }

    public static function get_cell_datetime_object($worksheet, $cell_index) {
        $value = $worksheet->getCell($cell_index)->getValue();
        if (empty($value)) {
            return NULL;
        }
        return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);
    }

    public static function set_headers($config) {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $config->file_name. '.xls"');
        header('Cache-Control: max-age=0');
    }

    public static function output_report($spreadsheet, $config, $excel_library = self::PHPSPREADSHEET_EXCEL_LIBRARY) {
//        $writer = new Xlsx($spreadsheet);
//        $response =  new StreamedResponse(
//            function () use ($writer) {
//                $writer->save('php://output');
//            }
//        );
//        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
//        $response->headers->set('Content-Disposition', 'attachment;filename="ExportScan.xls"');
//        $response->headers->set('Cache-Control','max-age=0');
//        return $response;

//        $writer = new Xlsx($spreadsheet);
//        header('Content-Type: application/vnd.ms-excel');
//        header('Content-Disposition: attachment; filename="' . $config->file_name . '.xlsx"');
//        header('Access-Control-Allow-Methods', 'HEAD, GET, POST, PUT, PATCH, DELETE');
//        header('Access-Control-Allow-Headers', header('Access-Control-Request-Headers'));
//        header('Access-Control-Allow-Credentials', true);
//        header('Access-Control-Allow-Origin', '*');
//        return $writer->save("php://output");

//        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//        header('Content-Disposition: attachment;filename="'. $config->file_name .'.xlsx"');
//        header('Cache-Control: max-age=0');
//
        if ($excel_library == self::PHPSPREADSHEET_EXCEL_LIBRARY) {
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            ob_start();
            $writer->save('php://output');
            $excelOutput = ob_get_clean();
            return $excelOutput;
        } else {
            // $writer->openToFile($filePath); // write data to a file or to a PHP stream
            $spreadsheet->openToBrowser($config->file_name . '.xlsx'); // stream data directly to the browser
            $spreadsheet->close();
        }
    }

    public static function spout() {
        $writer = WriterFactory::create(Type::XLSX);
//        $writer = WriterEntityFactory::createXLSXWriter();
        // $writer = WriterEntityFactory::createODSWriter();
        // $writer = WriterEntityFactory::createCSVWriter();

        // $writer->openToFile($filePath); // write data to a file or to a PHP stream
        $writer->openToBrowser('test.xlsx'); // stream data directly to the browser

//        $cells = [
//            WriterEntityFactory::createCell('Carl'),
//            WriterEntityFactory::createCell('is'),
//            WriterEntityFactory::createCell('great!'),
//        ];
//
//        /** add a row at a time */
//        $singleRow = WriterEntityFactory::createRow($cells);
//        $writer->addRow($singleRow);
//
//        /** add multiple rows at a time */
//        $multipleRows = [
//            WriterEntityFactory::createRow($cells),
//            WriterEntityFactory::createRow($cells),
//        ];
//        $writer->addRows($multipleRows);

        /** Shortcut: add a row from an array of values */
        $values = ['Date Selection: 2020-12-01 - 2020-12-25', 'is', 'great!'];
//        $rowFromValues = WriterFactory::createRowFromArray($values);
        $writer->addRow($values);

        $writer->close();
    }

    /*
     * When a line break is found, Spout automatically sets the text to wrap.
     * Without this, you would only be able to see the 1st line.
     * https://gitter.im/box/spout?at=564274526420c33467a1428e
     */
    public static function remove_spout_line_breaks($str) {
        return trim($str);
    }
}