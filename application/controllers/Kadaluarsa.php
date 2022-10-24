<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kadaluarsa extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_kadaluarsa');
        $this->load->library('Pdf'); // MEMANGGIL LIBRARY YANG KITA BUAT TADI


    }

    public function index()
    {
        $data['kd'] = $this->M_kadaluarsa->tampil();
        $data['title'] = 'Barang Kadaluarsa';
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('Kadaluarsa/index', $data);
        $this->load->view('templates/footer');
    }

    public function cetak_pdf()
    {
        error_reporting(0); // AGAR ERROR MASALAH VERSI PHP TIDAK MUNCUL
        $pdf = new FPDF('P', 'mm', 'Letter');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Image('./assets/ruang-admin/img/logo/Tj.png');
        $pdf->Cell(0, 9, 'Trengginas Jaya Mart', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(200, 9, 'Jl. Sumur Bandung No. 12, Bandung ,Telp: (022) 253205,Fax: (022) 2532053', 0, 1, 'C');
        $pdf->Cell(0, 9, '', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Data Barang Kadaluarsa', 0, 1, 'C');
        $pdf->Cell(10, 10, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 6, 'No', 1, 0, 'C');
        $pdf->Cell(50, 6, 'Tanggal Kadaluarsa', 1, 0, 'C');
        $pdf->Cell(60, 6, 'Nama Barang', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Jumlah', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Satuan', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Jenis', 1, 1, 'C');
        $pdf->SetFont('Arial', '', 10);

        $query = $this->M_kadaluarsa->tampil();

        $brg = $query;
        $no = 0;
        foreach ($brg as $data) {
            $no++;
            $pdf->Cell(10, 6, $no, 1, 0, 'C');
            $pdf->Cell(50, 6, date('d-m-Y', strtotime($data['tanggal_kadaluarsa'])), 1, 0);
            $pdf->Cell(60, 6, $data['nama_barang'], 1, 0);
            $pdf->Cell(20, 6, $data['jumlah'], 1,);
            $pdf->Cell(20, 6, $data['satuan'], 1, 0);
            $pdf->Cell(20, 6, $data['nama_jenis'], 1, 1);
        }
        $pdf->Output('Laporan Barang Kadaluarsa.pdf', 'D');
    }

    public function cetak_excel()
    {
        // Read an Excel File
        $tmpfname = "example.xls";
        $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
        $objPHPExcel = $excelReader->load($tmpfname);

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Furkan Kahveci")
            ->setLastModifiedBy("Furkan Kahveci")
            ->setTitle("Office 2007 XLS Test Document")
            ->setSubject("Office 2007 XLS Test Document")
            ->setDescription("Description for Test Document")
            ->setKeywords("phpexcel office codeigniter php")
            ->setCategory("Test result file");

        // Create a first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', "Furkan");
        $objPHPExcel->getActiveSheet()->setCellValue('B1', "Kahveci");
        $objPHPExcel->getActiveSheet()->setCellValue('C1', "KLU");
        $objPHPExcel->getActiveSheet()->setCellValue('D1', "Software Engineering");
        $objPHPExcel->getActiveSheet()->setCellValue('E1', "11.06.2019");

        // Hide F and G column
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setVisible(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setVisible(false);

        // Set auto size
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

        // Add data
        for ($i = 10; $i <= 50; $i++) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, "Name $i")
                ->setCellValue('B' . $i, "Surname $i")
                ->setCellValue('C' . $i, "University $i")
                ->setCellValue('D' . $i, "Department $i")
                ->setCellValue('E' . $i, "Date");
        }

        // Set Font Color, Font Style and Font Alignment
        $stil = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                )
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle('A3:E3')->applyFromArray($stil);

        // Merge Cells
        $objPHPExcel->getActiveSheet()->mergeCells('A5:E5');
        $objPHPExcel->getActiveSheet()->setCellValue('A5', "MERGED CELL");
        $objPHPExcel->getActiveSheet()->getStyle('A5:E5')->applyFromArray($stil);

        // Save Excel xls File
        $filename = "filename.xls";
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=' . $filename);
        $objWriter->save('php://output');
    }
}
