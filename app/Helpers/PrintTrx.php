<?php
namespace App\Helpers;

use App\Models\Stores;
use App\Models\Transactions;
use Carbon\Carbon;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class PrintTrx
{
    protected function getDetailStore($id)
    {
        $result = Stores::find($id);
        return $result;
    }
    
    protected function create4Column($column1, $column2, $column3, $column4)
    {

        // lebar column
        $sizeColumn1 = 12; 
        $sizeColumn2 = 6; 
        $sizeColumn3 = 10; 
        $sizeColumn4 = 9;
        
        // wordwrap
        $column1 = wordwrap($column1, $sizeColumn1, "\n", true);
        $column2 = wordwrap($column2, $sizeColumn2, "\n", true);
        $column3 = wordwrap($column3, $sizeColumn3, "\n", true);
        $column4 = wordwrap($column4, $sizeColumn4, "\n", true);

        $column1Arr = explode("\n", $column1);
        $column2Arr = explode("\n", $column2);
        $column3Arr = explode("\n", $column3);
        $column4Arr = explode("\n", $column4);

        $countRowMax = max(count($column1Arr), count($column2Arr), count($column3Arr), count($column4Arr));

        $resultRow = [];

        for ($i=0; $i < $countRowMax; $i++) { 
            
            // add space
            $resultColumn1 = str_pad((isset($column1Arr[$i]) ? $column1Arr[$i] : ""), $sizeColumn1, " ");
            $resultColumn2 = str_pad((isset($column2Arr[$i]) ? $column2Arr[$i] : ""), $sizeColumn2, " ");

            // align right
            $resultColumn3 = str_pad((isset($column3Arr[$i]) ? $column3Arr[$i] : ""), $sizeColumn3, " ", STR_PAD_LEFT);
            $resultColumn4 = str_pad((isset($column4Arr[$i]) ? $column4Arr[$i] : ""), $sizeColumn4, " ", STR_PAD_LEFT);

            // push to array result
            $resultRow[] = $resultColumn1 . " " . $resultColumn2 . " " . $resultColumn3 . " " . $resultColumn4;

        }

        return implode($resultRow, "\n") . "\n";
    }

    function invoice($id)
    {
        $os = env('OS', 'linux');
        $PRINTER_DEVICE = env('PRINTER_DEVICE', "EPSON TM-U220 Receipt");
        $connector = null;
        $connection = env('CONNECTION', 'usb');
        if($connection == "usb") {
            if($os == "windows") {
                $connector = new WindowsPrintConnector($PRINTER_DEVICE); // ini untuk windows. ambil nama printer sharingnya
            } elseif($os == "linux") {
                $connector = new FilePrintConnector($PRINTER_DEVICE);
            } 
        } elseif($connection == "ethernet") {
            $connector = new NetworkPrintConnector(env('IP_PRINTER_SHARING', "10.x.x.x"), env('PORT_PRINTER_SHARING', "9100"));
        }
        $printer = new Printer($connector);
        $trx = Transactions::with('carts.product', 'customer', 'user')->where('id', $id)->first();

        // detail stores
        $store = $this->getDetailStore(1);
        $nameStore = $store->nama_toko ?? "RitterCoding";
        $alamat = $store->alamat ?? "Cirebon";

        // heading
        $printer->initialize();
        $printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT); // perbesar huruf
        $printer->setJustification(Printer::JUSTIFY_CENTER); // Setting teks menjadi rata tengah
        $printer->text("$nameStore\n");
                  
        // alamat
        $printer->initialize();
        $printer->setJustification(Printer::JUSTIFY_CENTER); // Setting teks menjadi rata tengah
        $printer->text("$alamat\n");
        $printer->text("\n");

        // data transactions
        $printer->initialize();
        $nameKasir = $trx->user != null ? $trx->user->name : "-";
        $customer = $trx->customer != null ? $trx->customer->nama : "-";
        $printer->text("Kasir : ". $nameKasir . "\n");
        $printer->text("Waktu : ". $trx->tgl_transaksi . "\n");
        $printer->text("Customer : ". $customer . "\n");
        $printer->text("No Invoice : ". $trx->no_invoice . "\n");
        
        // create table product
        $printer->initialize();
        $printer->text("----------------------------------------\n");
        $printer->text($this->create4Column("Barang", "Harga", "Diskon", "Subtotal"));
        $printer->text("----------------------------------------\n");
        foreach ($trx->carts as $cart) {
            $nameProd = $cart->product != null ? $cart->product->nama_barang : "tidak valid";
            $subTotal = $cart->qyt * ($cart->harga_product - $cart->diskon_product);
            $printer->text($this->create4Column($nameProd, $cart->qyt . ' x ' . $cart->harga_product, $cart->diskon_product, $subTotal));
        }
        $printer->text("----------------------------------------\n");
        $printer->text($this->create4Column('', '', "Sub Total", $trx->total + $trx->diskon_transaksi));
        $printer->text($this->create4Column('', '', "Diskon", $trx->diskon_transaksi));
        $printer->text($this->create4Column('', '', "Total", $trx->total));
        $printer->text($this->create4Column('', '', "Bayar", $trx->cash));
        $printer->text($this->create4Column('', '', "Kembalian", $trx->change));
        $printer->text("Ket : " . $trx->keterangan ?? "-" . "\n");
        $printer->text("\n");

        // Pesan penutup
        $printer->initialize();
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Terima kasih telah berbelanja\n");
        $printer->text("$nameStore\n");

        $printer->feed(5); // mencetak 5 baris kosong agar terangkat (pemotong kertas saya memiliki jarak 5 baris dari toner)
        $printer->close();
    }
}