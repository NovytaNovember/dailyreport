<?php

namespace App\Controllers;

use App\Models\CppModel;

use App\Models\ProductionTodayModel;
use App\Models\TotalRitaseModel;
use App\Models\UseOfHeavyVehiclesModel;
use App\Models\CppRuntimeModel;
use App\Models\OlcRuntimeModel;
use App\Models\DailyStockCppModel;
use App\Models\DailyTankCapModel;
use App\Models\WaterLevelOnSettlingPondModel;
use App\Models\WaterLevelOnReservoirTankModel;
use App\Models\ChemicalStartronGreyContainerModel;
use App\Models\ChemicalPIC130WhiteContainerModel;
use App\Models\UseOfKWHPLNtoCPPModel;
use App\Models\UseOfFuelGenset04Model;
use App\Models\UseOfFuelGenset05Model;
use App\Models\ActivityTodayModel;
use App\Models\PmModel;
use App\Models\CmModel;
use App\Models\HaulingToPltuModel;

use PhpOffice\PhpSpreadsheet\IOFactory;

class CppController extends BaseController
{
    public function index()
    {
        $cppModel = new CppModel();
        $data = [
            'dataCpp' => $cppModel->getAllData()
        ];

        return view('cpp/cpp', $data);
    }

    public function uploadFile()
    {
        date_default_timezone_set('Asia/Makassar');
        $file = $this->request->getFile('file_upload');
        $uploadDate = $this->request->getPost('upload_date');
        $uploadDateTime = date('Y-m-d H:i:s', strtotime($uploadDate . ' ' . date('H:i:s')));

        if ($file->isValid() && !$file->hasMoved()) {
            // Tentukan lokasi upload file
            $uploadPath = ROOTPATH . 'public/uploads/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true); // Buat folder jika belum ada
            }

            // Pindahkan file ke lokasi yang diinginkan
            $filePath = $uploadPath . $file->getName();
            $file->move($uploadPath);

            // Inisialisasi model CPP
            $cppModel = new CppModel();

            // Data untuk diinsert ke tabel CPP
            $data = [
                'nama_cpp' => $file->getName(), // Nama file
                'upload_date' => $uploadDate,  // Tanggal upload
                'actual_upload_time' => $uploadDateTime // Waktu aktual upload
            ];

            // Debug data sebelum insert
            log_message('debug', 'Data to insert in CPP table: ' . json_encode($data));

            // Insert data ke database
            $id_cpp = $cppModel->insert($data, true);

            // Cek apakah data berhasil diinsert
            if ($id_cpp) {
                // Load file Excel menggunakan PhpSpreadsheet
                $spreadsheet = IOFactory::load($filePath);
                $sheet = $spreadsheet->getActiveSheet();

                try {
                    // Panggil fungsi untuk menyimpan data terkait
                    $this->saveCppRuntime($sheet, $id_cpp);
                    $this->saveProductionToday($sheet, $uploadDate, $id_cpp);
                    $this->saveTotalRitase($sheet, $uploadDate, $id_cpp);
                    $this->saveUseOfHeavyVehicles($sheet, $uploadDate, $id_cpp);
                    $this->saveOlcRuntime($sheet, $uploadDate, $id_cpp);
                    $this->saveDailyStockCpp($sheet, $id_cpp, $uploadDate);
                    $this->saveDailyTankCap($sheet, $id_cpp, $uploadDate);
                    $this->saveWaterLevelOnSettlingPond($sheet, $id_cpp, $uploadDate);
                    $this->saveWaterLevelOnRecervoirTank($sheet, $id_cpp, $uploadDate);
                    $this->saveChemicalStartronGreyContainer($sheet, $id_cpp, $uploadDate);
                    $this->saveChemicalPIC130WhiteContainer($sheet, $id_cpp, $uploadDate);
                    $this->saveUseOfKWHPLNtoCPP($sheet, $id_cpp, $uploadDate);
                    $this->saveUseOfFuelGenset04($sheet, $id_cpp, $uploadDate);
                    $this->saveUseOfFuelGenset05($sheet, $id_cpp, $uploadDate);
                    $this->saveActivityToday($sheet, $id_cpp, $uploadDate);
                    $this->savePm($sheet, $id_cpp, $uploadDate);
                    $this->saveCm($sheet, $id_cpp, $uploadDate);
                    $this->saveHaulingToPltu($sheet, $id_cpp, $uploadDate);

                    // Redirect dengan pesan sukses
                    return redirect()->to('/cpp')->with('message', 'File berhasil diunggah dan data disimpan ke database!');
                } catch (\Exception $e) {
                    log_message('error', 'Error saving related data: ' . $e->getMessage());

                    // Jika error, hapus data utama yang sudah diinsert
                    $cppModel->delete($id_cpp);

                    return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data terkait: ' . $e->getMessage());
                }
            } else {
                log_message('error', 'Failed to insert data into CPP table: ' . json_encode($data));
                return redirect()->back()->with('error', 'Gagal menyimpan data utama ke tabel CPP.');
            }
        }

        return redirect()->back()->with('error', 'Gagal mengunggah file.');
    }

    private function saveProductionToday($sheet, $uploadDate, $id_cpp)
    {
        $productionTodayModel = new ProductionTodayModel();
        $dataToInsert = [];
        for ($row = 8; $row <= 10; $row++) {
            $dataToInsert[] = [
                'id_cpp' => $id_cpp,
                'production_today' => $sheet->getCell('B' . $row)->getValue(),
                'awal' => intval(preg_replace('/\D/', '', $sheet->getCell('D' . $row)->getValue())),
                'total' => intval(preg_replace('/[^0-9]/', '', $sheet->getCell('H' . $row)->getValue())),
                'akhir' => $this->calculateAkhir(
                    intval(preg_replace('/\D/', '', $sheet->getCell('D' . $row)->getValue())),
                    intval(preg_replace('/[^0-9]/', '', $sheet->getCell('H' . $row)->getValue()))
                ),
                'tanggal' => $uploadDate
            ];
        }

        foreach ($dataToInsert as $dataRow) {
            $productionTodayModel->insert($dataRow);
        }
    }

    private function calculateAkhir($awal, $total)
    {
        return $awal + $total;
    }

    private function saveTotalRitase($sheet, $uploadDate, $id_cpp)
    {
        $totalRitaseModel = new TotalRitaseModel();
        $dataToInsert = [];
        for ($row = 13; $row <= 16; $row++) {
            $dataToInsert[] = [
                'id_cpp' => $id_cpp,
                'ritase_type' => $sheet->getCell('B' . $row)->getValue(),
                'total_ritase' => preg_replace('/\D/', '', $sheet->getCell('D' . $row)->getValue()),
                'tanggal' => $uploadDate
            ];
        }

        foreach ($dataToInsert as $dataRow) {
            $totalRitaseModel->insert($dataRow);
        }
    }

    private function saveUseOfHeavyVehicles($sheet, $uploadDate, $id_cpp)
    {
        $useOfHeavyVehiclesModel = new UseOfHeavyVehiclesModel();
        $dataRows = $sheet->toArray(null, true, true, true);

        for ($rowNumber = 21; $rowNumber <= 52; $rowNumber++) {
            if (empty($dataRows[$rowNumber]['B']) && empty($dataRows[$rowNumber]['C']) && empty($dataRows[$rowNumber]['D']) && empty($dataRows[$rowNumber]['E']) && empty($dataRows[$rowNumber]['F']) && empty($dataRows[$rowNumber]['G']) && empty($dataRows[$rowNumber]['H']) && empty($dataRows[$rowNumber]['I'])) {
                continue;
            }

            $startHm = !empty($dataRows[$rowNumber]['D']) ? floatval(str_replace(',', '.', $dataRows[$rowNumber]['D'])) : 0;
            $stopHm = !empty($dataRows[$rowNumber]['E']) ? floatval(str_replace(',', '.', $dataRows[$rowNumber]['E'])) : 0;
            $totalHm = $stopHm - $startHm;

            $data = [
                'id_cpp' => $id_cpp,
                'company' => $dataRows[$rowNumber]['B'],
                'unit' => $dataRows[$rowNumber]['C'],
                'start_hm' => $startHm,
                'stop_hm' => $stopHm,
                'operator' => $dataRows[$rowNumber]['F'],
                'total_hm' => $totalHm,
                'fuel' => isset($dataRows[$rowNumber]['H']) ? floatval($dataRows[$rowNumber]['H']) : null,
                'remark' => $dataRows[$rowNumber]['I'],
                'tanggal' => $uploadDate
            ];

            $useOfHeavyVehiclesModel->insert($data);
        }
    }

    private function saveCppRuntime($sheet, $id_cpp)
    {
        $cppRuntimeModel = new CppRuntimeModel();
        $dataToInsert = [];

        // Variabel akumulator untuk total runtime dan delay time
        $totalRunTime = 0;
        $totalDelayTime = 0;

        // Loop untuk membaca data dari baris tertentu (misalnya dari baris 56 hingga 72)
        for ($row = 56; $row <= 72; $row++) {
            // Baca data dari sheet
            $explanation = !empty($sheet->getCell('B' . $row)->getValue()) ? $sheet->getCell('B' . $row)->getValue() : "Tidak ada data";
            $rate = !empty($sheet->getCell('C' . $row)->getValue()) ? floatval($sheet->getCell('C' . $row)->getValue()) : "Tidak ada data";
            $runTimeFrom = !empty($sheet->getCell('D' . $row)->getValue()) ? $sheet->getCell('D' . $row)->getValue() : "Tidak ada data";
            $runTimeTo = !empty($sheet->getCell('E' . $row)->getValue()) ? $sheet->getCell('E' . $row)->getValue() : "Tidak ada data";
            $durationMinutesRuntime = !empty($sheet->getCell('F' . $row)->getValue()) ? intval($sheet->getCell('F' . $row)->getValue()) : 0; // Jika kosong, set ke 0
            $delayTimeFrom = !empty($sheet->getCell('G' . $row)->getValue()) ? $sheet->getCell('G' . $row)->getValue() : "Tidak ada data";
            $delayTimeTo = !empty($sheet->getCell('H' . $row)->getValue()) ? $sheet->getCell('H' . $row)->getValue() : "Tidak ada data";
            $durationMinutesDelay = !empty($sheet->getCell('I' . $row)->getValue()) ? intval($sheet->getCell('I' . $row)->getValue()) : 0; // Jika kosong, set ke 0
            $typeDelay = !empty($sheet->getCell('J' . $row)->getValue()) ? $sheet->getCell('J' . $row)->getValue() : "Tidak ada data";

            // Akumulasi runtime dan delay hanya jika ada data
            $totalRunTime += $durationMinutesRuntime;
            $totalDelayTime += $durationMinutesDelay;

            // Menambahkan data per baris ke array
            $dataToInsert[] = [
                'id_cpp' => $id_cpp,
                'explanation' => $explanation,
                'rate' => $rate,
                'run_time_from' => $runTimeFrom !== "Tidak ada data" ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($runTimeFrom)->format('H:i:s') : "Tidak ada data",
                'run_time_to' => $runTimeTo !== "Tidak ada data" ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($runTimeTo)->format('H:i:s') : "Tidak ada data",
                'duration_minutes_runtime' => $durationMinutesRuntime,
                'delay_time_from' => $delayTimeFrom !== "Tidak ada data" ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($delayTimeFrom)->format('H:i:s') : "Tidak ada data",
                'delay_time_to' => $delayTimeTo !== "Tidak ada data" ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($delayTimeTo)->format('H:i:s') : "Tidak ada data",
                'duration_minutes_delay' => $durationMinutesDelay,
                'type_delay' => $typeDelay
            ];
        }

        // Hitung total_type_delayed sebagai penjumlahan dari total_run_time dan total_delay_time
        $totalTypeDelayed = $totalRunTime + $totalDelayTime;

        // Masukkan data total ke dalam baris terakhir dari array dataToInsert
        if (!empty($dataToInsert)) {
            // Pastikan total di-set dengan nilai yang benar
            $dataToInsert[count($dataToInsert) - 1]['total_run_time'] = $totalRunTime ?: "Tidak ada data"; // Set ke "Tidak ada data" jika null
            $dataToInsert[count($dataToInsert) - 1]['total_delay_time'] = $totalDelayTime ?: "Tidak ada data"; // Set ke "Tidak ada data" jika null
            $dataToInsert[count($dataToInsert) - 1]['total_type_delayed'] = $totalTypeDelayed ?: "Tidak ada data"; // Set ke "Tidak ada data" jika null
        }

        // Connect ke database
        $db = \Config\Database::connect();
        $builder = $db->table('cpp_runtime');

        // Insert semua data per baris
        foreach ($dataToInsert as $data) {
            $builder->insert($data);
        }
    }

    private function saveOlcRuntime($sheet, $uploadDate, $id_cpp)
    {
        $olcRuntimeModel = new \App\Models\OlcRuntimeModel();
        $dataToInsert = [];
        $totalRunTime = 0;
        $totalDelayTime = 0;

        for ($row = 77; $row <= 94; $row++) {
            $runTimeFrom = $sheet->getCell('D' . $row)->getValue();
            $runTimeTo = $sheet->getCell('E' . $row)->getValue();
            $delayTimeFrom = $sheet->getCell('G' . $row)->getValue();
            $delayTimeTo = $sheet->getCell('H' . $row)->getValue();

            $runTimeFromFormatted = $this->convertExcelTime($runTimeFrom);
            $runTimeToFormatted = $this->convertExcelTime($runTimeTo);

            $durationRuntime = 0;
            if ($runTimeFromFormatted && $runTimeToFormatted) {
                $startTimestamp = strtotime($runTimeFromFormatted);
                $endTimestamp = strtotime($runTimeToFormatted);

                if ($endTimestamp < $startTimestamp) {
                    $endTimestamp += 24 * 60 * 60; // Penyesuaian lintas hari
                }
                $durationRuntime = ($endTimestamp - $startTimestamp) / 60;
            }

            $durationDelay = 0;
            if ($delayTimeFrom && $delayTimeTo) {
                $delayStartTimestamp = strtotime($this->convertExcelTime($delayTimeFrom));
                $delayEndTimestamp = strtotime($this->convertExcelTime($delayTimeTo));

                if ($delayEndTimestamp < $delayStartTimestamp) {
                    $delayEndTimestamp += 24 * 60 * 60; // Penyesuaian lintas hari
                }

                $durationDelay = ($delayEndTimestamp - $delayStartTimestamp) / 60;
            }

            if ($durationRuntime < 0 || $durationRuntime > 1440) {
                $durationRuntime = 0;
            }
            if ($durationDelay < 0 || $durationDelay > 1440) {
                $durationDelay = 0;
            }

            $totalRunTime += $durationRuntime;
            $totalDelayTime += $durationDelay;

            $dataToInsert[] = [
                'id_cpp' => $id_cpp,
                'explanation' => $sheet->getCell('B' . $row)->getValue() ?? '',
                'rate' => floatval($sheet->getCell('C' . $row)->getValue() ?? 0),
                'run_time_from' => $runTimeFromFormatted,
                'run_time_to' => $runTimeToFormatted,
                'duration_minutes_runtime' => intval($durationRuntime),
                'delay_time_from' => $this->convertExcelTime($delayTimeFrom),
                'delay_time_to' => $this->convertExcelTime($delayTimeTo),
                'duration_minutes_delay' => intval($durationDelay),
                'type_delay' => $sheet->getCell('J' . $row)->getValue() ?? '',
                'total_run_time' => null, // Jangan masukkan total di baris individual
                'total_delay_time' => null,
                'total_type_delayed' => null,
            ];
        }

        // Tambahkan baris total ke dalam database tanpa mengisi duration runtime/delay
        $dataToInsert[] = [
            'id_cpp' => $id_cpp,
            'explanation' => 'Total',
            'rate' => null,
            'run_time_from' => null,
            'run_time_to' => null,
            'duration_minutes_runtime' => null, // Tidak mengisi di kolom duration_minutes_runtime
            'delay_time_from' => null,
            'delay_time_to' => null,
            'duration_minutes_delay' => null, // Tidak mengisi di kolom duration_minutes_delay
            'type_delay' => null,
            'total_run_time' => $totalRunTime,
            'total_delay_time' => $totalDelayTime,
            'total_type_delayed' => $totalRunTime + $totalDelayTime,
        ];

        log_message('debug', 'Data to insert into OLC Runtime: ' . json_encode($dataToInsert));

        try {
            $olcRuntimeModel->insertBatch($dataToInsert);
            log_message('info', 'OLC Runtime data successfully inserted.');
        } catch (\Exception $e) {
            log_message('error', 'Error inserting OLC Runtime data: ' . $e->getMessage());
            throw $e;
        }
    }

    // Fungsi untuk konversi waktu
    function convertExcelTime($timeValue)
    {
        if (is_numeric($timeValue)) {
            $timeObj = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($timeValue);
            return $timeObj->format('H:i:s');
        }
        return null;
    }

    private function saveDailyStockCpp($sheet, $id_cpp, $uploadDate)
    {
        $dailyStockCppModel = new \App\Models\DailyStockCppModel();

        // Ambil data dari sheet dengan validasi
        $awalShift = $sheet->getCell('D99')->getCalculatedValue();
        $akhirShift = $sheet->getCell('D100')->getCalculatedValue();
        $totalConsumption = $sheet->getCell('D101')->getCalculatedValue();
        $supply = $sheet->getCell('F101')->getCalculatedValue();

        $awalShiftFlow = $sheet->getCell('F99')->getCalculatedValue();
        $akhirShiftFlow = $sheet->getCell('F100')->getCalculatedValue();

        // Validasi data apakah kosong atau tidak numerik
        $data = [
            'id_cpp' => $id_cpp,
            'awal_shift' => is_numeric($awalShift) ? floatval($awalShift) : 0,
            'akhir_shift' => is_numeric($akhirShift) ? floatval($akhirShift) : 0,
            'total_consumption' => is_numeric($totalConsumption) ? floatval($totalConsumption) : 0,
            'supply' => is_numeric($supply) ? floatval($supply) : 0,
            'awal_shift_flow' => is_numeric($awalShiftFlow) ? floatval($awalShiftFlow) : 0,
            'akhir_shift_flow' => is_numeric($akhirShiftFlow) ? floatval($akhirShiftFlow) : 0,
            'tanggal' => $uploadDate,
        ];

        // Log untuk debugging
        log_message('debug', 'Daily Stock CPP Data to Insert: ' . json_encode($data));

        // Simpan data ke database
        try {
            $dailyStockCppModel->insert($data);
            log_message('info', 'Daily Stock CPP berhasil disimpan.');
        } catch (\Exception $e) {
            log_message('error', 'Gagal menyimpan Daily Stock CPP: ' . $e->getMessage());
        }
    }

    private function saveDailyTankCap($sheet, $id_cpp, $uploadDate)
    {
        $dailyTankCapModel = new \App\Models\DailyTankCapModel();

        // Mengambil nilai yang dihitung dari Excel (pastikan formula sudah benar)
        $basedOnActualStorageTankLevelAwalShift = $sheet->getCell('D104')->getCalculatedValue();
        $basedOnActualStorageTankLevelAkhirShift = $sheet->getCell('D105')->getCalculatedValue();
        $totalConsumption = $sheet->getCell('D106')->getCalculatedValue(); // Perhitungan D104 - D105

        $useOfFuelAwalShift = $sheet->getCell('F104')->getCalculatedValue();
        $useOfFuelAkhirShift = $sheet->getCell('F105')->getCalculatedValue();
        $consumption = $sheet->getCell('F106')->getCalculatedValue();

        $flowMeterOutletAwalShift = $sheet->getCell('H104')->getCalculatedValue();
        $flowMeterOutletAkhirShift = $sheet->getCell('H105')->getCalculatedValue();
        $flowMeterTotal = $sheet->getCell('H106')->getCalculatedValue(); // Perhitungan H104 - H105

        // Debug: Log nilai yang diambil untuk pengecekan
        log_message('debug', 'Based on Actual Storage Tank Level Awal Shift: ' . $basedOnActualStorageTankLevelAwalShift);
        log_message('debug', 'Based on Actual Storage Tank Level Akhir Shift: ' . $basedOnActualStorageTankLevelAkhirShift);
        log_message('debug', 'Total Consumption (D106): ' . $totalConsumption);
        log_message('debug', 'Use of Fuel Awal Shift (F104): ' . $useOfFuelAwalShift);
        log_message('debug', 'Use of Fuel Akhir Shift (F105): ' . $useOfFuelAkhirShift);
        log_message('debug', 'Consumption (F106): ' . $consumption);
        log_message('debug', 'Flow Meter Outlet Awal Shift (H104): ' . $flowMeterOutletAwalShift);
        log_message('debug', 'Flow Meter Outlet Akhir Shift (H105): ' . $flowMeterOutletAkhirShift);
        log_message('debug', 'Flow Meter Total (H106): ' . $flowMeterTotal);

        // Pastikan data yang disimpan adalah angka yang valid, gunakan floatval untuk konversi
        $data = [
            'id_cpp' => $id_cpp,
            'tanggal' => date('Y-m-d'), // Menggunakan tanggal hari ini
            'awal_shift_based' => is_numeric($basedOnActualStorageTankLevelAwalShift) ? floatval($basedOnActualStorageTankLevelAwalShift) : 0,
            'akhir_shift_based' => is_numeric($basedOnActualStorageTankLevelAkhirShift) ? floatval($basedOnActualStorageTankLevelAkhirShift) : 0,
            'total_consumption' => is_numeric($totalConsumption) ? floatval($totalConsumption) : 0,
            'useoffuel_awal_shift' => is_numeric($useOfFuelAwalShift) ? floatval($useOfFuelAwalShift) : 0,
            'useoffuel_akhir_shift' => is_numeric($useOfFuelAkhirShift) ? floatval($useOfFuelAkhirShift) : 0,
            'consumption' => is_numeric($consumption) ? floatval($consumption) : 0,
            'flow_meter_outlet_awal_shift' => is_numeric($flowMeterOutletAwalShift) ? floatval($flowMeterOutletAwalShift) : 0,
            'flow_meter_outlet_akhir_shift' => is_numeric($flowMeterOutletAkhirShift) ? floatval($flowMeterOutletAkhirShift) : 0,
            // Menggunakan pengurangan (-) untuk total flow meter
            'total' => is_numeric($flowMeterOutletAwalShift) && is_numeric($flowMeterOutletAkhirShift)
                ? floatval($flowMeterOutletAwalShift - $flowMeterOutletAkhirShift) : 0
        ];

        // Debug: Log hasil data yang akan disimpan ke DB
        log_message('debug', 'Data yang akan disimpan: ' . json_encode($data));

        try {
            // Simpan data ke tabel daily_tank_cap
            $dailyTankCapModel->insert($data);
        } catch (\Exception $e) {
            log_message('error', 'Gagal menyimpan data ke daily_tank_cap: ' . $e->getMessage());
            return false;
        }

        return true;
    }

    public function saveWaterLevelOnSettlingPond($sheet, $id_cpp, $uploadDate)
    {
        // Periksa apakah id_cpp valid
        $cppModel = new \App\Models\CppModel();
        $cppExists = $cppModel->find($id_cpp);

        if (!$cppExists) {
            throw new \Exception('ID CPP tidak ditemukan di tabel CPP.');
        }

        // Lanjutkan dengan proses penyimpanan ke water_level_on_settling_pond
        $waterLevelOnSettlingPondModel = new \App\Models\WaterLevelOnSettlingPondModel();

        $basedAwalShift = $sheet->getCell('D109')->getCalculatedValue();
        $basedAkhirShift = $sheet->getCell('D110')->getCalculatedValue();
        $totalConsumption = $basedAwalShift - $basedAkhirShift;

        $useOfWaterAwalShift = $sheet->getCell('F109')->getCalculatedValue();
        $useOfWaterAkhirShift = $sheet->getCell('F110')->getCalculatedValue();
        $consumption = $useOfWaterAkhirShift - $useOfWaterAwalShift;

        $data = [
            'id_cpp' => $id_cpp,
            'tanggal' => $uploadDate,
            'based_awal_shift' => floatval($basedAwalShift),
            'based_akhir_shift' => floatval($basedAkhirShift),
            'total_consumption' => floatval($totalConsumption),
            'use_of_water_awal_shift' => floatval($useOfWaterAwalShift),
            'use_of_water_akhir_shift' => floatval($useOfWaterAkhirShift),
            'consumption' => floatval($consumption),
        ];

        // Simpan data ke database
        $waterLevelOnSettlingPondModel->insert($data);
    }

    public function saveWaterLevelOnRecervoirTank($sheet, $id_cpp, $uploadDate)
    {
        // Ambil data awal_shift dan akhir_shift dari file Excel
        $awal_shift = $sheet->getCell('D114')->getValue(); // Misalnya di kolom D baris 114
        $akhir_shift = $sheet->getCell('D115')->getValue(); // Misalnya di kolom D baris 115

        // Cek apakah nilai yang diambil valid
        if (is_numeric($awal_shift) && is_numeric($akhir_shift)) {

            // Pastikan nilai numerik menjadi float jika perlu
            $awal_shift = (float) $awal_shift;
            $akhir_shift = (float) $akhir_shift;

            // Validasi apakah tanggal yang diterima sudah dalam format yang benar (YYYY-MM-DD)
            $isValidDate = \DateTime::createFromFormat('Y-m-d', $uploadDate) !== false;
            if (!$isValidDate) {
                log_message('error', 'Tanggal yang diberikan tidak valid: ' . $uploadDate);
                return;
            }

            // Inisialisasi model untuk tabel water_level_on_recervoir_tank
            $waterLevelOnReservoirTankModel = new WaterLevelOnReservoirTankModel();

            // Siapkan data yang akan disimpan
            $data = [
                'id_cpp' => $id_cpp,           // ID CPP (dari parameter)
                'awal_shift' => $awal_shift,   // Awal Shift
                'akhir_shift' => $akhir_shift, // Akhir Shift
                'tanggal' => $uploadDate,      // Tanggal upload (dari parameter)
            ];

            // Insert data ke dalam tabel water_level_on_recervoir_tank
            $insertSuccess = $waterLevelOnReservoirTankModel->insertData($data);  // Menggunakan insertData untuk menyimpan data

            // Cek apakah insert berhasil
            if ($insertSuccess === true) {
                // Log untuk debugging (opsional)
                log_message('debug', 'Data berhasil disimpan ke tabel water_level_on_recervoir_tank: ' . json_encode($data));
            } else {
                // Jika insert gagal (terdapat error)
                log_message('error', 'Gagal menyimpan data ke tabel water_level_on_recervoir_tank: ' . json_encode($insertSuccess));
            }
        } else {
            // Pastikan data yang valid (nilai awal_shift dan akhir_shift) ada sebelum log
            $errorData = [
                'awal_shift' => $awal_shift,
                'akhir_shift' => $akhir_shift,
                'tanggal' => $uploadDate,
            ];

            // Log jika nilai awal_shift atau akhir_shift tidak valid
            log_message('error', 'Nilai awal_shift atau akhir_shift tidak valid: ' . json_encode($errorData));
        }
    }

    public function saveChemicalStartronGreyContainer($sheet, $id_cpp, $uploadDate)
    {
        // Ambil data dari file Excel
        $based_awal_shift = $sheet->getCell('D118')->getValue();  // Kolom D, Baris 118
        $based_akhir_shift = $sheet->getCell('D119')->getValue(); // Kolom D, Baris 119

        // Pastikan nilai numerik menjadi float jika perlu
        $based_awal_shift = (float)$based_awal_shift;
        $based_akhir_shift = (float)$based_akhir_shift;

        // Hitung total_consumption berdasarkan selisih D118 dan D119
        $total_consumption = $based_awal_shift - $based_akhir_shift;

        // Hitung use_awal_shift dan use_akhir_shift sesuai perhitungan
        $use_awal_shift = $based_awal_shift * 133;
        $use_akhir_shift = $based_akhir_shift * 133;

        // Konsumsi sesuai petunjuk
        $consumption = $sheet->getCell('F120')->getValue();  // Ambil nilai dari F120 jika ada

        // Siapkan data untuk disimpan
        $data = [
            'id_cpp' => $id_cpp,
            'based_awal_shift' => $based_awal_shift,
            'based_akhir_shift' => $based_akhir_shift,
            'use_awal_shift' => $use_awal_shift,
            'use_akhir_shift' => $use_akhir_shift,
            'total_consumption' => $total_consumption,  // Hasil perhitungan D118 - D119
            'consumption' => (float)$consumption,  // Konsumsi dari F120
            'tanggal' => $uploadDate,  // Tanggal upload yang diterima
        ];

        // Log data yang akan disimpan
        log_message('debug', 'Data yang akan disimpan ke database: ' . json_encode($data));

        // Inisialisasi model
        $chemicalModel = new \App\Models\ChemicalStartronGreyContainerModel();

        // Insert data
        $insertSuccess = $chemicalModel->insertData($data);

        // Log hasil insert
        if ($insertSuccess) {
            log_message('debug', 'Data berhasil disimpan ke tabel chemical_startron_grey_container');
        } else {
            log_message('error', 'Gagal menyimpan data ke tabel chemical_startron_grey_container');
        }
    }

    public function saveChemicalPIC130WhiteContainer($sheet, $id_cpp, $uploadDate)
    {
        // Ambil data dari file Excel
        $based_awal_shift = $sheet->getCell('D123')->getValue();  // Kolom D, Baris 123
        $based_akhir_shift = $sheet->getCell('D124')->getValue(); // Kolom D, Baris 124

        // Pastikan nilai numerik menjadi float jika perlu
        $based_awal_shift = (float)$based_awal_shift;
        $based_akhir_shift = (float)$based_akhir_shift;

        // Hitung total_consumption berdasarkan perhitungan D123 + D124
        $total_consumption = $based_awal_shift + $based_akhir_shift;

        // Hitung use_awal_shift (D123 * 128)
        $use_awal_shift = $based_awal_shift * 128;

        // Hitung use_akhir_shift (D124 * 128)
        $use_akhir_shift = $based_akhir_shift * 128;

        // Hitung consumption (use_awal_shift - use_akhir_shift)
        $consumption = $use_awal_shift - $use_akhir_shift;

        // Siapkan data untuk disimpan
        $data = [
            'id_cpp' => $id_cpp,
            'based_awal_shift' => $based_awal_shift,
            'based_akhir_shift' => $based_akhir_shift,
            'total_consumption' => $total_consumption,  // Hasil perhitungan D123 + D124
            'use_awal_shift' => $use_awal_shift,  // Hasil perhitungan D123 * 128
            'use_akhir_shift' => $use_akhir_shift,  // Hasil perhitungan D124 * 128
            'consumption' => $consumption,  // Hasil perhitungan use_awal_shift - use_akhir_shift
            'tanggal' => $uploadDate,  // Tanggal upload yang diterima
        ];

        // Log data yang akan disimpan
        log_message('debug', 'Data yang akan disimpan ke database: ' . json_encode($data));

        // Inisialisasi model
        $chemicalModel = new ChemicalPIC130WhiteContainerModel();

        // Insert data
        $insertSuccess = $chemicalModel->insertData($data);

        // Log hasil insert
        if ($insertSuccess) {
            log_message('debug', 'Data berhasil disimpan ke tabel chemical_pic130_white_container');
        } else {
            log_message('error', 'Gagal menyimpan data ke tabel chemical_pic130_white_container');
        }
    }

    public function saveUseOfKWHPLNtoCPP($sheet, $id_cpp, $uploadDate)
    {
        // Inisialisasi model
        $useOfKWHPLNtoCPPModel = new UseOfKWHPLNtoCPPModel();  // Tidak ada error jika namespace dan file model sudah benar

        // Ambil nilai awal dan akhir dari sheet Excel
        $awal = $sheet->getCell('D128')->getValue();  // Kolom D, Baris 128 (Awal)
        $akhir = $sheet->getCell('F128')->getValue(); // Kolom F, Baris 128 (Akhir)

        // Pastikan nilai numerik menjadi float
        $awal = (float)$awal;
        $akhir = (float)$akhir;

        // Hitung total_use (akhir - awal)
        $total_use = $akhir - $awal;

        // Siapkan data untuk disimpan
        $data = [
            'id_cpp' => $id_cpp,  // ID CPP yang diterima
            'awal' => $awal,       // Nilai awal
            'akhir' => $akhir,     // Nilai akhir
            'total_use' => $total_use,  // Total use hasil perhitungan
            'tanggal' => $uploadDate  // Tanggal upload
        ];

        // Log data yang akan disimpan
        log_message('debug', 'Data yang akan disimpan ke database: ' . json_encode($data));

        // Insert data
        $insertSuccess = $useOfKWHPLNtoCPPModel->insertData($data);

        // Log hasil insert
        if ($insertSuccess) {
            log_message('debug', 'Data berhasil disimpan ke tabel use_of_kwh_pln_to_cpp');
        } else {
            log_message('error', 'Gagal menyimpan data ke tabel use_of_kwh_pln_to_cpp');
        }

        return $insertSuccess;  // Kembalikan true jika berhasil, false jika gagal
    }

    public function saveUseOfFuelGenset04($sheet, $id_cpp, $uploadDate)
    {
        // Inisialisasi model
        $useOfFuelGenset04Model = new UseOfFuelGenset04Model();

        // Ambil nilai dari Excel untuk data awal
        $input_awal = $sheet->getCell('E131')->getValue();  // Kolom E, Baris 131 (Input Awal)
        $output_awal = $sheet->getCell('E132')->getValue(); // Kolom E, Baris 132 (Output Awal)
        $kwh_awal = $sheet->getCell('E134')->getValue();    // Kolom E, Baris 134 (KWH Awal)
        $kvrah_awal = $sheet->getCell('E135')->getValue();  // Kolom E, Baris 135 (Kvarh Awal)
        $run_hour_awal = $sheet->getCell('E136')->getValue(); // Kolom E, Baris 136 (Run Hour Awal)

        // Ambil nilai dari Excel untuk data akhir
        $input_akhir = $sheet->getCell('G131')->getValue();  // Kolom G, Baris 131 (Input Akhir)
        $output_akhir = $sheet->getCell('G132')->getValue(); // Kolom G, Baris 132 (Output Akhir)
        $kwh_akhir = $sheet->getCell('G134')->getValue();    // Kolom G, Baris 134 (KWH Akhir)
        $kvrah_akhir = $sheet->getCell('G135')->getValue();  // Kolom G, Baris 135 (Kvarh Akhir)
        $run_hour_akhir = $sheet->getCell('G136')->getValue(); // Kolom G, Baris 136 (Run Hour Akhir)

        // Ambil nilai perhitungan dari Excel
        $total_input_consumption = $sheet->getCell('J131')->getValue();  // Kolom J, Baris 131 (Input Consumption)
        $total_output_consumption = $sheet->getCell('J132')->getValue(); // Kolom J, Baris 132 (Output Consumption)
        $total_fuel_consumption = $sheet->getCell('J133')->getValue();   // Kolom J, Baris 133 (Fuel Consumption)
        $total_kwh = $sheet->getCell('J134')->getValue();    // Kolom J, Baris 134 (Total KWH)
        $total_kvarh = $sheet->getCell('J135')->getValue();  // Kolom J, Baris 135 (Total Kvarh)
        $total_run_hour = $sheet->getCell('J136')->getValue(); // Kolom J, Baris 136 (Total Run Hour)

        // Siapkan data untuk disimpan
        $data = [
            'id_cpp' => $id_cpp,  // ID CPP yang diterima
            'input_awal' => (float)$input_awal,
            'output_awal' => (float)$output_awal,
            'kwh_awal' => (float)$kwh_awal,
            'kvrah_awal' => (float)$kvrah_awal,
            'run_hour_awal' => (float)$run_hour_awal,
            'input_akhir' => (float)$input_akhir,
            'output_akhir' => (float)$output_akhir,
            'kwh_akhir' => (float)$kwh_akhir,
            'kvrah_akhir' => (float)$kvrah_akhir,
            'run_hour_akhir' => (float)$run_hour_akhir,
            'total_input_consumption' => (float)$total_input_consumption,
            'total_output_consumption' => (float)$total_output_consumption,
            'total_fuel_consumption' => (float)$total_fuel_consumption,
            'total_kwh' => (float)$total_kwh,
            'total_kvarh' => (float)$total_kvarh,
            'total_run_hour' => (float)$total_run_hour,
            'tanggal' => $uploadDate
        ];

        // Simpan data ke dalam database
        $insertSuccess = $useOfFuelGenset04Model->insertData($data);

        // Log hasil insert
        if ($insertSuccess) {
            log_message('debug', 'Data berhasil disimpan ke tabel use_of_fuel_genset04');
        } else {
            log_message('error', 'Gagal menyimpan data ke tabel use_of_fuel_genset04');
        }

        return $insertSuccess; // Kembalikan hasil dari fungsi insert
    }

    // Fungsi untuk menyimpan data use_of_fuel_genset05
    public function saveUseOfFuelGenset05($sheet, $id_cpp, $uploadDate)
    {
        // Ambil nilai dari Excel untuk data awal dan akhir
        $input_awal = $sheet->getCell('E140')->getValue();  // Kolom E, Baris 140 (Input Awal)
        $output_awal = $sheet->getCell('E141')->getValue(); // Kolom E, Baris 141 (Output Awal)
        $kwh_awal = $sheet->getCell('E143')->getValue();    // Kolom E, Baris 143 (KWH Awal)
        $kvrah_awal = $sheet->getCell('E144')->getValue();  // Kolom E, Baris 144 (Kvarh Awal)
        $run_hour_awal = $sheet->getCell('E145')->getValue(); // Kolom E, Baris 145 (Run Hour Awal)

        // Ambil nilai dari Excel untuk data akhir
        $input_akhir = $sheet->getCell('G140')->getValue();  // Kolom G, Baris 140 (Input Akhir)
        $output_akhir = $sheet->getCell('G141')->getValue(); // Kolom G, Baris 141 (Output Akhir)
        $kwh_akhir = $sheet->getCell('G143')->getValue();    // Kolom G, Baris 143 (KWH Akhir)
        $kvrah_akhir = $sheet->getCell('G144')->getValue();  // Kolom G, Baris 144 (Kvarh Akhir)
        $run_hour_akhir = $sheet->getCell('G145')->getValue(); // Kolom G, Baris 145 (Run Hour Akhir)

        // Cek dan pastikan nilai yang diambil adalah angka
        $input_awal = (float) $input_awal;  // Casting ke float
        $output_awal = (float) $output_awal;
        $kwh_awal = (float) $kwh_awal;
        $kvrah_awal = (float) $kvrah_awal;
        $run_hour_awal = (float) $run_hour_awal;

        $input_akhir = (float) $input_akhir;
        $output_akhir = (float) $output_akhir;
        $kwh_akhir = (float) $kwh_akhir;
        $kvrah_akhir = (float) $kvrah_akhir;
        $run_hour_akhir = (float) $run_hour_akhir;

        // Perhitungan untuk Input Consumption, Output Consumption, Fuel Consumption
        $total_input_consumption = $input_akhir - $input_awal;  // G140 - E140
        $total_output_consumption = $output_akhir - $output_awal; // G141 - E141
        $total_fuel_consumption = (float) $sheet->getCell('J133')->getValue() - (float) $sheet->getCell('J131')->getValue(); // J133 - J131
        $total_kwh = $kwh_akhir - $kwh_awal;    // G143 - E143
        $total_kvarh = $kvrah_akhir - $kvrah_awal;  // G144 - E144
        $total_run_hour = $run_hour_akhir - $run_hour_awal; // G145 - E145

        // Log untuk memeriksa hasil perhitungan
        log_message('debug', 'Total Input Consumption: ' . $total_input_consumption);
        log_message('debug', 'Total Output Consumption: ' . $total_output_consumption);
        log_message('debug', 'Total Fuel Consumption: ' . $total_fuel_consumption);
        log_message('debug', 'Total KWH: ' . $total_kwh);
        log_message('debug', 'Total Kvarh: ' . $total_kvarh);
        log_message('debug', 'Total Run Hour: ' . $total_run_hour);

        // Siapkan data untuk disimpan
        $data = [
            'id_cpp' => $id_cpp,  // ID CPP yang diterima
            'input_awal' => $input_awal,
            'output_awal' => $output_awal,
            'kwh_awal' => $kwh_awal,
            'kvrah_awal' => $kvrah_awal,
            'run_hour_awal' => $run_hour_awal,
            'input_akhir' => $input_akhir,
            'output_akhir' => $output_akhir,
            'kwh_akhir' => $kwh_akhir,
            'kvrah_akhir' => $kvrah_akhir,
            'run_hour_akhir' => $run_hour_akhir,
            'total_input_consumption' => $total_input_consumption,
            'total_output_consumption' => $total_output_consumption,
            'total_fuel_consumption' => $total_fuel_consumption,
            'total_kwh' => $total_kwh,
            'total_kvarh' => $total_kvarh,
            'total_run_hour' => $total_run_hour,
            'tanggal' => $uploadDate
        ];

        // Log data sebelum disimpan untuk memastikan semuanya benar
        log_message('debug', 'Data yang akan disimpan: ' . print_r($data, true));

        // Simpan data ke dalam database
        $useOfFuelGenset05Model = new UseOfFuelGenset05Model();
        $insertSuccess = $useOfFuelGenset05Model->insertData($data);

        // Log hasil insert
        if ($insertSuccess) {
            log_message('debug', 'Data berhasil disimpan ke tabel use_of_fuel_genset05');
        } else {
            log_message('error', 'Gagal menyimpan data ke tabel use_of_fuel_genset05');
        }

        return $insertSuccess; // Kembalikan hasil dari fungsi insert
    }

    public function saveActivityToday($sheet, $id_cpp, $uploadDate)
    {
        // Instance dari ActivityTodayModel
        $activityTodayModel = new ActivityTodayModel();

        // Loop untuk memastikan semua 15 baris (143-163) diproses
        for ($row = 149; $row <= 163; $row++) {
            // Ambil data dari kolom yang sesuai
            $no = $sheet->getCell('A' . $row)->getValue();  // Kolom A (No)
            $nama_activity_today = $sheet->getCell('B' . $row)->getValue();  // Kolom B (Nama Activity Today)
            $status_activity_today = $sheet->getCell('C' . $row)->getValue();  // Kolom C (Status Activity Today)

            // Jika kolom kosong, atur nilai default
            $no = !empty($no) ? $no : $row - 142; // Jika kosong, isi dengan nomor urut baris
            $nama_activity_today = !empty($nama_activity_today) ? $nama_activity_today : 'Tidak ada data'; // Default teks
            $status_activity_today = !empty($status_activity_today) ? $status_activity_today : 'Belum selesai'; // Default status

            $tanggal = $uploadDate;  // Tanggal diambil dari parameter yang diberikan

            // Siapkan data untuk disimpan
            $data = [
                'id_cpp' => $id_cpp,  // ID CPP
                'no' => $no,  // Nomor urut aktivitas
                'nama_activity_today' => $nama_activity_today,  // Nama aktivitas
                'status_activity_today' => $status_activity_today,  // Status aktivitas
                'tanggal' => $tanggal  // Tanggal aktivitas
            ];

            // Validasi data sebelum disimpan
            if ($activityTodayModel->validate($data)) {
                // Simpan data ke dalam database
                $result = $activityTodayModel->insertActivityToday($data);

                if ($result) {
                    log_message('info', "Data inserted: " . json_encode($data)); // Log jika data berhasil disimpan
                } else {
                    log_message('error', "Failed to insert data: " . json_encode($data)); // Log jika gagal
                }
            } else {
                // Log error validasi jika data tidak valid
                log_message('error', "Validation failed: " . json_encode($data));
            }
        }

        // Kembali ke halaman yang sesuai setelah data disimpan
        return redirect()->to('/activity-today-list');  // Sesuaikan dengan rute yang diinginkan
    }

    public function savePm($sheet, $id_cpp, $uploadDate)
    {
        // Instance dari PmModel
        $pmModel = new PmModel();

        // Loop untuk mengambil data aktivitas dari baris 165 hingga 176
        for ($row = 165; $row <= 176; $row++) {
            // Ambil data dari kolom yang sesuai
            $no_pm = $sheet->getCell('A' . $row)->getValue();  // Kolom A (No PM)
            $nama_pm = $sheet->getCell('B' . $row)->getValue();  // Kolom B (Nama PM)
            $status_pm = $sheet->getCell('C' . $row)->getValue();  // Kolom C (Status PM)

            // Jika kolom kosong, atur nilai default
            $no_pm = !empty($no_pm) ? $no_pm : $row - 164; // Jika kosong, isi dengan nomor urut baris
            $nama_pm = !empty($nama_pm) ? $nama_pm : 'Tidak ada data'; // Default teks
            $status_pm = !empty($status_pm) ? $status_pm : 'Belum selesai'; // Default status

            // Tanggal diambil dari parameter yang diberikan (misalnya dari uploadDate)
            $tanggal = $uploadDate;  // Tanggal upload atau tanggal aktivitas

            // Siapkan data untuk disimpan
            $data = [
                'id_cpp' => $id_cpp,  // ID CPP sebagai foreign key
                'no_pm' => $no_pm,  // Nomor PM
                'nama_pm' => $nama_pm,  // Nama PM
                'status_pm' => $status_pm,  // Status PM
                'tanggal' => $tanggal  // Tanggal aktivitas
            ];

            // Validasi data sebelum disimpan
            if ($pmModel->validate($data)) {
                // Simpan data ke dalam database
                $result = $pmModel->insertPm($data);

                if ($result) {
                    log_message('info', "Data inserted: " . json_encode($data)); // Log jika data berhasil disimpan
                } else {
                    log_message('error', "Failed to insert data: " . json_encode($data)); // Log jika gagal
                }
            } else {
                // Log error validasi jika data tidak valid
                log_message('error', "Validation failed: " . json_encode($data));
            }
        }

        // Kembali ke halaman yang sesuai setelah data disimpan
        return redirect()->to('/pm-list');  // Sesuaikan dengan rute yang diinginkan
    }

    public function saveCm($sheet, $id_cpp, $uploadDate)
    {
        // Instance dari CmModel
        $cmModel = new CmModel();

        // Loop untuk mengambil data dari baris 178 hingga 186
        for ($row = 178; $row <= 186; $row++) {
            // Ambil data dari kolom yang sesuai
            $no_cm = $sheet->getCell('A' . $row)->getValue();  // Kolom A (No CM)
            $nama_cm = $sheet->getCell('B' . $row)->getValue();  // Kolom B (Nama CM)
            $status_cm = $sheet->getCell('C' . $row)->getValue();  // Kolom C (Status CM)

            // Jika kolom kosong, atur nilai default
            $no_cm = !empty($no_cm) ? $no_cm : $row - 177; // Jika kosong, isi dengan nomor urut baris
            $nama_cm = !empty($nama_cm) ? $nama_cm : 'Tidak ada data'; // Default teks
            $status_cm = !empty($status_cm) ? $status_cm : 'Belum selesai'; // Default status

            // Tanggal diambil dari parameter yang diberikan (misalnya dari uploadDate)
            $tanggal = $uploadDate;  // Tanggal upload atau tanggal aktivitas

            // Siapkan data untuk disimpan
            $data = [
                'id_cpp' => $id_cpp,  // ID CPP sebagai foreign key
                'no_cm' => $no_cm,  // Nomor CM
                'nama_cm' => $nama_cm,  // Nama CM
                'status_cm' => $status_cm,  // Status CM
                'tanggal' => $tanggal  // Tanggal aktivitas
            ];

            // Validasi data sebelum disimpan
            if ($cmModel->validate($data)) {
                // Simpan data ke dalam database
                $result = $cmModel->insertCm($data);

                if ($result) {
                    log_message('info', "Data inserted: " . json_encode($data)); // Log jika data berhasil disimpan
                } else {
                    log_message('error', "Failed to insert data: " . json_encode($data)); // Log jika gagal
                }
            } else {
                // Log error validasi jika data tidak valid
                log_message('error', "Validation failed: " . json_encode($data));
            }
        }

        // Kembali ke halaman yang sesuai setelah data disimpan
        return redirect()->to('/cm-list');  // Sesuaikan dengan rute yang diinginkan
    }

    // Fungsi untuk menyimpan data Hauling to PLTU
    public function saveHaulingToPltu($sheet, $id_cpp, $uploadDate)
    {
        // Mengambil data dari baris 189-192, misalnya dari kolom A sampai H
        $rows = $sheet->rangeToArray('A189:H192');

        // Model untuk menyimpan data ke dalam database
        $haulingModel = new HaulingToPltuModel();

        // Variabel untuk menyimpan total waktu (total_time)
        $totalTime = 0;

        // Iterasi untuk setiap baris (189–192)
        foreach ($rows as $index => $row) {
            // Ambil data dari setiap kolom
            $no = $row[0];  // Kolom A: Nomor
            $hauling_to_pltu_explanation = $row[1];  // Kolom B: Penjelasan hauling
            $rate = $row[2];  // Kolom C: Rate (T/Hr)
            $time_from = $row[3];  // Kolom D: Time From
            $time_to = $row[4];  // Kolom E: Time To

            // Menghitung durasi dalam menit (selisih antara time_to dan time_from)
            $duration_minutes = $this->calculateDuration($time_from, $time_to);
            $totalTime += $duration_minutes;  // Menambahkan durasi ke total waktu

            // Data untuk tanggal
            $tanggal = $uploadDate;

            // Menyusun data yang akan disimpan ke database
            $data = [
                'id_cpp' => $id_cpp,
                'no' => $no,
                'hauling_to_pltu_explanation' => $hauling_to_pltu_explanation,
                'rate' => $rate,
                'time_from' => $time_from,
                'time_to' => $time_to,
                'duration_minutes' => $duration_minutes,
                'total_time' => $totalTime,
                'tanggal' => $tanggal
            ];

            // Debug data sebelum insert
            log_message('debug', 'Data to insert into hauling_to_pltu: ' . json_encode($data));

            // Menyimpan data ke dalam tabel
            if (!$haulingModel->insertHaulingToPltu($data)) {
                echo 'Error saat insert data';
                return;
            }
        }

        echo 'Data Hauling To PLTU berhasil disimpan!';
    }

    public function calculateDuration($time_from, $time_to)
    {
        // Mengubah waktu dari string ke timestamp
        $start_time = strtotime($time_from);
        $end_time = strtotime($time_to);

        // Jika konversi gagal
        if ($start_time === false || $end_time === false) {
            return 0;  // Mengembalikan 0 jika ada kesalahan dalam konversi
        }

        // Menghitung durasi dalam menit
        $duration = ($end_time - $start_time) / 60;

        // Jika waktu selesai lebih kecil dari waktu mulai, anggap itu terjadi keesokan harinya
        if ($duration < 0) {
            $duration += 24 * 60;  // Menambahkan 24 jam dalam menit jika waktu selesai lebih kecil
        }

        return $duration;
    }


    public function rincian($id)
    {
        $cppModel = new CppModel();
        $fileData = $cppModel->getById($id);

        if (!$fileData) {
            return "Data tidak ditemukan.";
        }

        $filePath = ROOTPATH . 'public/uploads/' . $fileData['nama_cpp'];
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $dataRows = $sheet->toArray();

        $html = '<div class="table-responsive"><table class="table table-bordered"><thead><tr>';
        foreach ($dataRows[0] as $header) {
            $html .= '<th>' . esc($header) . '</th>';
        }
        $html .= '</tr></thead><tbody>';

        foreach (array_slice($dataRows, 1) as $row) {
            $html .= '<tr>';
            foreach ($row as $cell) {
                $html .= '<td>' . esc($cell) . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody></table></div>';

        return $html;
    }

    public function edit($id)
    {
        $cppModel = new CppModel();
        $fileData = $cppModel->getById($id);

        if (!$fileData) {
            return "Data tidak ditemukan.";
        }

        $filePath = ROOTPATH . 'public/uploads/' . $fileData['nama_cpp'];
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $dataRows = $sheet->toArray();

        $html = '<form action="' . base_url('cpp/update') . '" method="post">';
        $html .= '<input type="hidden" name="id_cpp" value="' . $id . '">';

        // Tombol Update di bagian kanan atas
        $html .= '<div class="text-end mb-4"><button type="submit" class="btn btn-primary">Update</button></div>';

        $html .= '<div class="table-responsive"><table class="table table-bordered"><thead><tr>';

        // Header tabel
        foreach ($dataRows[0] as $header) {
            $html .= '<th>' . esc($header) . '</th>';
        }
        $html .= '</tr></thead><tbody>';

        // Isi tabel
        foreach (array_slice($dataRows, 1) as $rowIndex => $row) {
            $html .= '<tr>';
            foreach ($row as $cellIndex => $cell) {
                // Menggunakan input field dengan tampilan minimal untuk kolom yang dapat diedit
                $html .= '<td>';
                $html .= '<input type="text" class="form-control" name="data[' . $rowIndex . '][' . $cellIndex . ']" value="' . esc($cell) . '" style="border: none; background: transparent; width: 100%; padding: 0; margin: 0;">';
                $html .= '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody></table></div>';

        $html .= '</form>';

        return $html;
    }


   // Fungsi update
public function update()
{
    $id = $this->request->getPost('id_cpp');
    $updatedData = $this->request->getPost('data');

    // Model untuk mendapatkan data CPP berdasarkan ID
    $cppModel = new CppModel();
    $fileData = $cppModel->getById($id);

    if (!$fileData) {
        return redirect()->back()->with('error', 'Data tidak ditemukan.');
    }

    // Tentukan path untuk file Excel
    $filePath = ROOTPATH . 'public/uploads/' . $fileData['nama_cpp'];

    if (!file_exists($filePath)) {
        return redirect()->back()->with('error', 'File tidak ditemukan.');
    }

    // Load file Excel
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
    $sheet = $spreadsheet->getActiveSheet();

    // Perbarui data Excel berdasarkan data yang diterima dari form
    foreach ($updatedData as $rowIndex => $row) {
        foreach ($row as $cellIndex => $cell) {
            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($cellIndex + 1);
            $sheet->setCellValue($columnLetter . ($rowIndex + 2), $cell);  // Update Excel sesuai dengan data baru
        }
    }

    // Simpan perubahan ke file Excel
    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
    try {
        $writer->save($filePath);
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal menyimpan perubahan ke file Excel: ' . $e->getMessage());
    }

    // Panggil fungsi untuk update tabel terkait setelah memperbarui file Excel
    $uploadDate = date('Y-m-d'); // Tentukan tanggal upload
    try {
        $this->updateProductionToday($sheet, $id);
        $this->updateTotalRitase($sheet, $id);
        $this->updateUseOfHeavyVehicles($sheet, $id);
        $this->updateCppRuntime($sheet, $id);
        $this->updateOlcRuntime($sheet, $id);
        $this->updateDailyStockCpp($sheet, $id);
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal memperbarui data tabel terkait: ' . $e->getMessage());
    }

    return redirect()->to('/cpp')->with('message', 'Data CPP berhasil diperbarui.');
}



    // Fungsi updateProductionToday
    private function updateProductionToday($sheet, $id_cpp)
    {
        $productionTodayModel = new ProductionTodayModel();
        $updatedData = $this->request->getPost('data'); // Data yang dikirimkan dari form

        foreach ($updatedData as $rowIndex => $row) {
            // Ambil nilai 'awal' dan 'total' dari form dan sheet
            $awal = intval(preg_replace('/\D/', '', $sheet->getCell('D' . ($rowIndex + 8))->getValue()));  // Nilai 'awal' dari sheet
            $total = intval(preg_replace('/[^0-9]/', '', $sheet->getCell('H' . ($rowIndex + 8))->getValue())); // Nilai 'total' dari sheet

            // Hitung nilai 'akhir' menggunakan calculateAkhir
            $akhir = $this->calculateAkhir($awal, $total);

            $productionToday = [
                'production_today' => $sheet->getCell('B' . ($rowIndex + 8))->getValue(), // Ambil nilai 'production_today' dari sheet
                'awal' => $awal, // Nilai 'awal' dari form atau sheet
                'total' => $total, // Nilai 'total' dari form atau sheet
                'akhir' => $akhir, // Hasil perhitungan 'akhir'
                'tanggal' => date('Y-m-d') // Tanggal hari ini
            ];

            // Update data di database berdasarkan id_cpp dan production_today
            $productionTodayModel->where('id_cpp', $id_cpp)
                ->where('production_today', $productionToday['production_today'])
                ->set($productionToday)  // Set data yang akan diupdate
                ->update();
        }
    }

    // Fungsi updateTotalRitase
    private function updateTotalRitase($sheet, $id_cpp)
    {
        $totalRitaseModel = new TotalRitaseModel();

        // Ambil jumlah total baris yang akan diupdate, disesuaikan dengan jumlah data yang ada pada sheet
        $lastRow = $sheet->getHighestRow();

        // Loop melalui semua baris yang ada di sheet
        for ($rowIndex = 13; $rowIndex <= $lastRow; $rowIndex++) {
            // Ambil nilai dari sheet untuk setiap kolom
            $ritaseType = $sheet->getCell('B' . $rowIndex)->getValue();
            $totalRitase = preg_replace('/\D/', '', $sheet->getCell('D' . $rowIndex)->getValue());

            // Jika ritaseType atau totalRitase kosong, tandakan dengan "Tidak ada data"
            if (empty($ritaseType)) {
                $ritaseType = "Tidak ada data";
            }

            if (empty($totalRitase)) {
                $totalRitase = "Tidak ada data";
            }

            // Data yang akan diupdate
            $dataRow = [
                'ritase_type' => $ritaseType,
                'total_ritase' => $totalRitase,
                'tanggal' => date('Y-m-d')  // Tanggal hari ini
            ];

            // Update data di database berdasarkan id_cpp dan ritase_type
            $totalRitaseModel->where('id_cpp', $id_cpp)
                ->where('ritase_type', $ritaseType)
                ->set($dataRow)  // Set data yang akan diupdate
                ->update();
        }
    }

    // Fungsi updateUseOfHeavyVehicles
    private function updateUseOfHeavyVehicles($sheet, $id_cpp)
    {
        $useOfHeavyVehiclesModel = new UseOfHeavyVehiclesModel();
        $dataRows = $sheet->toArray(null, true, true, true); // Mengubah sheet menjadi array

        // Hapus semua data lama terkait dengan id_cpp
        $useOfHeavyVehiclesModel->where('id_cpp', $id_cpp)->delete();

        // Loop melalui baris dari 21 hingga 52 untuk memproses file upload
        for ($rowNumber = 21; $rowNumber <= 52; $rowNumber++) {
            // Ambil nilai dari sheet dan beri nilai default jika kosong
            $company = !empty($dataRows[$rowNumber]['B']) ? $dataRows[$rowNumber]['B'] : "Tidak ada data";
            $unit = !empty($dataRows[$rowNumber]['C']) ? $dataRows[$rowNumber]['C'] : "Tidak ada data";
            $startHm = !empty($dataRows[$rowNumber]['D']) ? floatval(str_replace(',', '.', $dataRows[$rowNumber]['D'])) : "Tidak ada data";
            $stopHm = !empty($dataRows[$rowNumber]['E']) ? floatval(str_replace(',', '.', $dataRows[$rowNumber]['E'])) : "Tidak ada data";
            $fuel = isset($dataRows[$rowNumber]['H']) && !empty($dataRows[$rowNumber]['H']) ? floatval(str_replace(',', '.', $dataRows[$rowNumber]['H'])) : "Tidak ada data";
            $remark = !empty($dataRows[$rowNumber]['I']) ? $dataRows[$rowNumber]['I'] : "Tidak ada data";

            // Hitung total_hm jika startHm dan stopHm ada, jika tidak beri "Tidak ada data"
            $totalHm = ($startHm !== "Tidak ada data" && $stopHm !== "Tidak ada data") ? $stopHm - $startHm : "Tidak ada data";

            // Siapkan data untuk diinsert ulang
            $data = [
                'id_cpp' => $id_cpp,
                'company' => $company,
                'unit' => $unit,
                'start_hm' => $startHm,
                'stop_hm' => $stopHm,
                'total_hm' => $totalHm,
                'fuel' => $fuel,
                'remark' => $remark,
                'tanggal' => date('Y-m-d') // Tanggal saat ini
            ];

            // Insert ulang data ke database
            $useOfHeavyVehiclesModel->insert($data);
        }
    }

    // Fungsi updateCppRuntime
    private function updateCppRuntime($sheet, $id_cpp)
    {
        $cppRuntimeModel = new CppRuntimeModel();
        $dataRows = $sheet->toArray(null, true, true, true); // Mengubah sheet menjadi array

        // Hapus semua data lama terkait dengan id_cpp
        $cppRuntimeModel->where('id_cpp', $id_cpp)->delete();

        // Variabel akumulator untuk total runtime dan delay time
        $totalRunTime = 0;
        $totalDelayTime = 0;

        // Loop untuk membaca data dari baris tertentu (misalnya dari baris 56 hingga 72)
        for ($rowNumber = 56; $rowNumber <= 72; $rowNumber++) {
            // Cek apakah semua kolom kosong
            $explanation = !empty($dataRows[$rowNumber]['B']) ? $dataRows[$rowNumber]['B'] : "Tidak ada data";
            $rate = !empty($dataRows[$rowNumber]['C']) ? floatval($dataRows[$rowNumber]['C']) : "Tidak ada data";
            $runTimeFrom = !empty($dataRows[$rowNumber]['D']) ? date('H:i:s', strtotime($dataRows[$rowNumber]['D'])) : "Tidak ada data";
            $runTimeTo = !empty($dataRows[$rowNumber]['E']) ? date('H:i:s', strtotime($dataRows[$rowNumber]['E'])) : "Tidak ada data";
            $durationMinutesRuntime = !empty($dataRows[$rowNumber]['F']) ? intval($dataRows[$rowNumber]['F']) : "Tidak ada data";
            $delayTimeFrom = !empty($dataRows[$rowNumber]['G']) ? date('H:i:s', strtotime($dataRows[$rowNumber]['G'])) : "Tidak ada data";
            $delayTimeTo = !empty($dataRows[$rowNumber]['H']) ? date('H:i:s', strtotime($dataRows[$rowNumber]['H'])) : "Tidak ada data";
            $durationMinutesDelay = !empty($dataRows[$rowNumber]['I']) ? intval($dataRows[$rowNumber]['I']) : "Tidak ada data";
            $typeDelay = !empty($dataRows[$rowNumber]['J']) ? $dataRows[$rowNumber]['J'] : "Tidak ada data";

            // Hitung total runtime dan delay time hanya jika data ada
            if ($durationMinutesRuntime !== "Tidak ada data") {
                $totalRunTime += $durationMinutesRuntime;
            }

            if ($durationMinutesDelay !== "Tidak ada data") {
                $totalDelayTime += $durationMinutesDelay;
            }

            // Siapkan data untuk diupdate
            $data = [
                'id_cpp' => $id_cpp,
                'explanation' => $explanation,
                'rate' => $rate,
                'run_time_from' => $runTimeFrom,
                'run_time_to' => $runTimeTo,
                'duration_minutes_runtime' => $durationMinutesRuntime,
                'delay_time_from' => $delayTimeFrom,
                'delay_time_to' => $delayTimeTo,
                'duration_minutes_delay' => $durationMinutesDelay,
                'type_delay' => $typeDelay,
            ];

            // Insert data ke dalam tabel
            $cppRuntimeModel->insert($data);
        }

        // Hitung total_type_delayed
        $totalTypeDelayed = $totalRunTime + $totalDelayTime;

        // Perbarui total runtime, delay time, dan total type delayed
        $cppRuntimeModel->where('id_cpp', $id_cpp)->set([
            'total_run_time' => $totalRunTime ?: 0, // Set to 0 if null
            'total_delay_time' => $totalDelayTime ?: 0, // Set to 0 if null
            'total_type_delayed' => $totalTypeDelayed ?: 0, // Set to 0 if null
        ])->update();
    }

    private function updateOlcRuntime($sheet, $id_cpp)
    {
        $olcRuntimeModel = new \App\Models\OlcRuntimeModel();
        $dataRows = $sheet->toArray(null, true, true, true);

        $totalRunTime = 0;
        $totalDelayTime = 0;

        $dataToUpdate = [];

        foreach ($dataRows as $rowNumber => $row) {
            $explanation = $row['B'] ?? null;
            if (empty($explanation) || strtolower(trim($explanation)) === 'total') {
                continue; // Lewati baris kosong atau baris "Total"
            }

            if ($rowNumber < 77 || $rowNumber > 94) {
                continue; // Pastikan hanya baris 77-94 yang diproses
            }

            $runTimeFrom = $row['D'] ?? null;
            $runTimeTo = $row['E'] ?? null;
            $delayTimeFrom = $row['G'] ?? null;
            $delayTimeTo = $row['H'] ?? null;

            $durationRuntime = 0;
            if ($runTimeFrom && $runTimeTo) {
                $startTimestamp = strtotime($runTimeFrom);
                $endTimestamp = strtotime($runTimeTo);
                if ($endTimestamp < $startTimestamp) {
                    $endTimestamp += 24 * 60 * 60; // Penyesuaian lintas hari
                }
                $durationRuntime = ($endTimestamp - $startTimestamp) / 60;
            }

            $durationDelay = 0;
            if ($delayTimeFrom && $delayTimeTo) {
                $delayStartTimestamp = strtotime($delayTimeFrom);
                $delayEndTimestamp = strtotime($delayTimeTo);

                if ($delayEndTimestamp < $delayStartTimestamp) {
                    $delayEndTimestamp += 24 * 60 * 60; // Penyesuaian lintas hari
                }

                $durationDelay = ($delayEndTimestamp - $delayStartTimestamp) / 60;
            }

            $totalRunTime += $durationRuntime;
            $totalDelayTime += $durationDelay;

            $dataToUpdate[] = [
                'id_cpp' => $id_cpp,
                'explanation' => $explanation,
                'rate' => floatval($row['C'] ?? 0),
                'run_time_from' => $runTimeFrom ? date('H:i:s', strtotime($runTimeFrom)) : null,
                'run_time_to' => $runTimeTo ? date('H:i:s', strtotime($runTimeTo)) : null,
                'duration_minutes_runtime' => $durationRuntime,
                'delay_time_from' => $delayTimeFrom ? date('H:i:s', strtotime($delayTimeFrom)) : null,
                'delay_time_to' => $delayTimeTo ? date('H:i:s', strtotime($delayTimeTo)) : null,
                'duration_minutes_delay' => $durationDelay,
                'type_delay' => $row['J'] ?? null,
            ];
        }

        // Pastikan baris 'Total' juga diperbarui
        $dataToUpdate[] = [
            'id_cpp' => $id_cpp,
            'explanation' => 'Total',
            'rate' => null,
            'run_time_from' => null,
            'run_time_to' => null,
            'duration_minutes_runtime' => null,
            'delay_time_from' => null,
            'delay_time_to' => null,
            'duration_minutes_delay' => null,
            'type_delay' => null,
            'total_run_time' => $totalRunTime,
            'total_delay_time' => $totalDelayTime,
            'total_type_delayed' => $totalRunTime + $totalDelayTime,
        ];

        // Gunakan transaksi untuk memastikan konsistensi data
        $db = \Config\Database::connect();
        $db->transStart();

        foreach ($dataToUpdate as $data) {
            // Pastikan hanya data yang sesuai yang diupdate
            $existingData = $olcRuntimeModel->where('id_cpp', $data['id_cpp'])
                ->where('explanation', $data['explanation'])
                ->first();

            if ($existingData) {
                log_message('debug', 'Updating data: ' . json_encode($data));
                // Update berdasarkan ID dari data yang ditemukan
                $olcRuntimeModel->update($existingData['id_olc_runtime'], $data);
            } else {
                log_message('debug', 'Inserting new data: ' . json_encode($data));
                // Insert data baru jika belum ada
                $olcRuntimeModel->insert($data);
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            log_message('error', 'Error during transaction.');
            throw new \Exception('Gagal memperbarui data OLC Runtime.');
        }
    }

    public function updateDailyStockCpp($sheet, $id)
{
    $dailyStockCppModel = new \App\Models\DailyStockCppModel();

    // Ambil data dari sheet
    $awalShift = $sheet->getCell('D99')->getCalculatedValue();
    $akhirShift = $sheet->getCell('D100')->getCalculatedValue();
    $totalConsumption = $sheet->getCell('D101')->getCalculatedValue();
    $supply = $sheet->getCell('F101')->getCalculatedValue();
    $awalShiftFlow = $sheet->getCell('F99')->getCalculatedValue();
    $akhirShiftFlow = $sheet->getCell('F100')->getCalculatedValue();

    // Log nilai yang diambil dari sheet untuk debugging
    log_message('debug', 'Raw values from sheet: awalShift=' . var_export($awalShift, true) . ', akhirShift=' . var_export($akhirShift, true) . 
                 ', totalConsumption=' . var_export($totalConsumption, true) . ', supply=' . var_export($supply, true) . 
                 ', awalShiftFlow=' . var_export($awalShiftFlow, true) . ', akhirShiftFlow=' . var_export($akhirShiftFlow, true));

    // Validasi data apakah kosong atau tidak numerik
    $data = [
        'awal_shift' => is_numeric($awalShift) ? floatval($awalShift) : 0,
        'akhir_shift' => is_numeric($akhirShift) ? floatval($akhirShift) : 0,
        'total_consumption' => is_numeric($totalConsumption) ? floatval($totalConsumption) : 0,
        'supply' => is_numeric($supply) ? floatval($supply) : 0,
        'awal_shift_flow' => is_numeric($awalShiftFlow) ? floatval($awalShiftFlow) : 0,
        'akhir_shift_flow' => is_numeric($akhirShiftFlow) ? floatval($akhirShiftFlow) : 0,
    ];

    // Log data yang akan diupdate
    log_message('debug', 'Prepared data for update: ' . json_encode($data));

    // Perbarui data berdasarkan ID
    try {
        $updateStatus = $dailyStockCppModel->updateData($id, $data);
        
        if ($updateStatus) {
            log_message('info', 'Daily Stock CPP berhasil diperbarui untuk ID: ' . $id);
        } else {
            log_message('warning', 'Tidak ada data yang diubah untuk ID: ' . $id);
        }
    } catch (\Exception $e) {
        log_message('error', 'Gagal memperbarui Daily Stock CPP: ' . $e->getMessage());
    }
}


    

    public function search()
    {
        $table = $this->request->getGet('table'); // Nama tabel
        $startDate = $this->request->getGet('startDate'); // Tanggal awal
        $endDate = $this->request->getGet('endDate'); // Tanggal akhir

        if (empty($table)) {
            return redirect()->back()->with('error', 'Silakan pilih tabel terlebih dahulu.');
        }

        $db = \Config\Database::connect();

        // Validasi apakah tabel ada di database
        if (!$db->tableExists($table)) {
            return redirect()->back()->with('error', 'Tabel tidak ditemukan.');
        }

        $builder = $db->table($table);

        // Filter tanggal
        if (!empty($startDate)) {
            $builder->where('DATE(tanggal) >=', $startDate);
        }
        if (!empty($endDate)) {
            $builder->where('DATE(tanggal) <=', $endDate);
        }

        // Eksekusi query
        $data = $builder->get()->getResultArray();

        // Tampilkan data berdasarkan tabel
        return view('cpp/result', [
            'data' => $data,
            'table' => $table,
        ]);
    }


    public function delete()
    {
        $cppModel = new CppModel();
        $id = $this->request->getPost('id_cpp');

        $fileData = $cppModel->getById($id);

        if (!$fileData) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // Hapus semua data terkait di tabel lain
        $productionTodayModel = new ProductionTodayModel();
        $totalRitaseModel = new TotalRitaseModel();
        $useOfHeavyVehiclesModel = new UseOfHeavyVehiclesModel();
        $cppRuntimeModel = new CppRuntimeModel();
        $olcRuntimeModel = new OlcRuntimeModel();
        $dailyStockCppModel = new DailyStockCppModel();
        $dailyTankCapModel = new DailyStockCppModel();
        $waterLevelOnSettlingPondModel = new WaterLevelOnSettlingPondModel();
        $waterLevelOnReservoirTankModel = new WaterLevelOnReservoirTankModel();
        $chemicalStartronGreyContainerModel = new ChemicalStartronGreyContainerModel();
        $chemicalPIC130WhiteContainerModel = new   ChemicalPIC130WhiteContainerModel();
        $useOfKWHPLNtoCPPModel = new   UseOfKWHPLNtoCPPModel();
        $useOfFuelGenset04Model = new   UseOfFuelGenset04Model();
        $useOfFuelGenset05Model = new   UseOfFuelGenset05Model();
        $activityTodayModel = new   ActivityTodayModel();
        $pmModel = new   PmModel();
        $cmModel = new   CmModel();
        $haulingToPltuModel = new   HaulingToPltuModel();

        $productionTodayModel->where('id_cpp', $id)->delete();
        $totalRitaseModel->where('id_cpp', $id)->delete();
        $useOfHeavyVehiclesModel->where('id_cpp', $id)->delete();
        $cppRuntimeModel->where('id_cpp', $id)->delete();
        $olcRuntimeModel->where('id_cpp', $id)->delete();
        $dailyStockCppModel->where('id_cpp', $id)->delete();
        $dailyTankCapModel->where('id_cpp', $id)->delete();
        $waterLevelOnSettlingPondModel->where('id_cpp', $id)->delete();
        $waterLevelOnReservoirTankModel->where('id_cpp', $id)->delete();
        $waterLevelOnReservoirTankModel->where('id_cpp', $id)->delete();
        $chemicalStartronGreyContainerModel->where('id_cpp', $id)->delete();
        $chemicalPIC130WhiteContainerModel->where('id_cpp', $id)->delete();
        $useOfKWHPLNtoCPPModel->where('id_cpp', $id)->delete();
        $useOfFuelGenset04Model->where('id_cpp', $id)->delete();
        $useOfFuelGenset05Model->where('id_cpp', $id)->delete();
        $activityTodayModel->where('id_cpp', $id)->delete();
        $pmModel->where('id_cpp', $id)->delete();
        $cmModel->where('id_cpp', $id)->delete();
        $haulingToPltuModel->where('id_cpp', $id)->delete();


        // Hapus data di tabel utama
        if ($cppModel->delete($id)) {
            return redirect()->to('/cpp')->with('message', 'Data berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus data utama.');
        }
    }


    public function download($id)
    {
        $cppModel = new CppModel();
        $fileData = $cppModel->getById($id);

        if (!$fileData) {
            return redirect()->to('/cpp')->with('error', 'File tidak ditemukan.');
        }

        $filePath = ROOTPATH . 'public/uploads/' . $fileData['nama_cpp'];
        return $this->response->download($filePath, null)->setFileName($fileData['nama_cpp']);
    }
}