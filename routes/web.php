<?php

use App\Http\Controllers\RM\BerkasRM;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Bpjs\DataInacbg;
use App\Http\Controllers\Bpjs\HomeCasemix;
use App\Http\Controllers\Bpjs\SettingBpjs;
use App\Http\Controllers\Bpjs\GabungBerkas;
use App\Http\Controllers\Laporan\BayarUmum;
use App\Http\Controllers\Bpjs\BpjsController;
use App\Http\Controllers\Test\TestController;
use App\Http\Controllers\Bpjs\ListPasienRalan;
use App\Http\Controllers\Bpjs\ListPasienRanap;
use App\Http\Controllers\Laporan\BayarPiutang;
use App\Http\Controllers\Laporan\PiutangRalan;
use App\Http\Controllers\Bpjs\CesmikController;
use App\Http\Controllers\Bpjs\ListPasienRalan2;
use App\Http\Controllers\AntrianPoli\AntrianPoli;
use App\Http\Controllers\Farmasi\BundlingFarmasi;
use App\Http\Controllers\Laporan\PembayaranRalan;
use App\Http\Controllers\BriggingBpjs\KirimTaskId;
use App\Http\Controllers\Laporan\PasienController;
use App\Http\Controllers\AntrianPoli\BwJadwaldokter;
use App\Http\Controllers\Bpjs\PrintCesmikController;
use App\Http\Controllers\DetailTindakan\RalanDokter;
use App\Http\Controllers\DetailTindakan\RanapDokter;
use App\Http\Controllers\Farmasi\SepResepController;
use App\Http\Controllers\Keperawatan\LaporanLogBook;
use App\Http\Controllers\DetailTindakan\OperasiAndVK;
use App\Http\Controllers\Keperawatan\HomeKeperawatan;
use App\Http\Controllers\Keperawatan\LaporanLogBook2;
use App\Http\Controllers\DetailTindakan\RalanParamedis;
use App\Http\Controllers\DetailTindakan\RanapParamedis;
use App\Http\Controllers\Farmasi\MinimalStokController;
use App\Http\Controllers\Returobat\ReturObatController;
use App\Http\Controllers\Farmasi\ViewSepResepController;
use App\Http\Controllers\DetailTindakan\PeriksaRadiologi;
use App\Http\Controllers\Keperawatan\PengawasKeperawatan;
use App\Http\Controllers\DetailTindakanUmum\RalanDokterUm;
use App\Http\Controllers\DetailTindakanUmum\RanapDokterUm;
use App\Http\Controllers\DetailTindakanUmum\OperasiAndVKUm;
use App\Http\Controllers\DetailTindakan\RalanDokterParamedis;
use App\Http\Controllers\DetailTindakan\RanapDokterParamedis;
use App\Http\Controllers\DetailTindakanUmum\RalanParamedisUm;
use App\Http\Controllers\DetailTindakanUmum\RanapParamedisUm;
use App\Http\Controllers\AntrianPendaftaran\AntrianPendaftaran;
use App\Http\Controllers\DetailTindakanUmum\PeriksaRadiologiUm;
use App\Http\Controllers\DetailTindakanUmum\RalanDokterParamedisUm;
use App\Http\Controllers\DetailTindakanUmum\RanapDokterParamedisUm;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/update', [AuthController::class, 'Maintance']);
Route::group(['middleware' => 'default'], function () {
    Route::get('/login', [AuthController::class, 'Login'])->name('login');
    Route::post('/mesinlogin', [AuthController::class, 'mesinLogin']);

Route::group(['middleware' => 'auth-rsbw'], function () {
    Route::get('/test', [TestController::class, 'dashboardTanggal']);
    Route::get('/test-delte', [TestController::class, 'TestDelete']);
    Route::get('/test-cari', [TestController::class, 'TestCari']);
    Route::get('/logout', [AuthController::class, 'Logout'])->name('logout');
    Route::get('/', [PasienController::class, 'Pasien']);

    // OBAT
    Route::get('/returObat', [ReturObatController::class, 'Obat'])->middleware('permision-rsbw:penyakit');
    Route::get('/cariNorm', [ReturObatController::class, 'Obat']);
    Route::get('/print/{id}', [ReturObatController::class, 'Print']);

    // CASEMIX
    Route::get('/list-pasein-ralan', [ListPasienRalan::class, 'lisPaseinRalan']);
    Route::get('/cari-list-pasein-ralan', [ListPasienRalan::class, 'cariListPaseinRalan']);
    Route::get('/list-pasein-ralan2', [ListPasienRalan2::class, 'lisPaseinRalan2']);
    Route::get('/list-pasein-ranap', [ListPasienRanap::class, 'lisPaseinRanap']);
    Route::get('/cari-list-pasein-ranap', [ListPasienRanap::class, 'cariListPaseinRanap']);
    Route::get('/casemix-home', [HomeCasemix::class, 'casemixHome']);
    Route::get('/casemix-home-cari', [HomeCasemix::class, 'casemixHomeCari']);
    Route::get('/cariNorawat-ClaimBpjs', [BpjsController::class, 'claimBpjs']);
    Route::post('/upload-berkas', [BpjsController::class, 'inputClaimBpjs']);
    Route::get('/carinorawat-casemix', [CesmikController::class, 'Casemix']);
    Route::get('/print-casemix', [PrintCesmikController::class, 'printCasemix']);
    Route::get('/gabung-berkas-casemix', [GabungBerkas::class, 'gabungBerkas']);
    Route::get('/data-inacbg', [DataInacbg::class, 'Inacbg']);
    Route::get('/setting-bpjs-casemix', [SettingBpjs::class, 'settingBpjsCasemix']);

    // FARMASI
    Route::get('/list-pasien-farmasi', [SepResepController::class, 'ListPasienFarmasi']);
    Route::get('/cari-list-pasien-farmasi', [SepResepController::class, 'CariListPasienFarmasi']);
    Route::get('/view-sep-resep', [ViewSepResepController::class, 'ViewBerkasSepResep']);
    Route::post('/upload-berkas-farmasi', [ViewSepResepController::class, 'UploadBerkasFarmasi']);
    Route::get('/download-sepresep-farmasi', [ViewSepResepController::class, 'DonwloadSEPResep']);
    Route::get('/download-hasilgabungberks', [ViewSepResepController::class, 'DonwloadHasilGabung']);
    Route::get('/print-sep-resep', [BundlingFarmasi::class, 'PrintBerkasSepResep']);
    Route::get('/gabung-berkas-farmasi', [BundlingFarmasi::class, 'GabungBergkas']);
    Route::get('/minimal-stok-obat', [MinimalStokController::class, 'MinimalStokObat']);

    // LAPORAN / KEUANGAN
    Route::get('/pembayaran-ralan', [PembayaranRalan::class, 'PembayaranRanal']);
    Route::get('/cari-pembayaran-ralan', [PembayaranRalan::class, 'CariPembayaranRanal']);
    Route::get('/piutang-ralan', [PiutangRalan::class, 'PiutangRalan']);
    Route::get('/cari-piutang-ralan', [PiutangRalan::class, 'CariPiutangRalan']);
    Route::get('/cari-bayar-piutang', [BayarPiutang::class, 'CariBayarPiutang']);
    Route::get('/cari-bayar-umum', [BayarUmum::class, 'CariBayarUmum']);

    // DETAIL TINDAKAN Asuransi
    Route::get('/ralan-dokter', [RalanDokter::class, 'RalanDokter']);
    Route::get('/ralan-paramedis', [RalanParamedis::class, 'RalanParamedis']);
    Route::get('/ralan-dokter-paramedis', [RalanDokterParamedis::class, 'RalanDokterParamedis']);
    Route::get('/operasi-and-vk', [OperasiAndVK::class, 'OperasiAndVK']);
    Route::get('/ranap-dokter', [RanapDokter::class, 'RanapDokter']);
    Route::get('/ranap-paramedis', [RanapParamedis::class, 'RanapParamedis']);
    Route::get('/ranap-dokter-paramedis', [RanapDokterParamedis::class, 'RanapDokterParamedis']);
    Route::get('/periksa-radiologi', [PeriksaRadiologi::class, 'PeriksaRadiologi']);

    // DETAIL TINDAKAN Umum
    Route::get('/ralan-dokter-umum', [RalanDokterUm::class, 'RalanDokterUm']);
    Route::get('/ralan-paramedis-umum', [RalanParamedisUm::class, 'RalanParamedisUm']);
    Route::get('/ralan-dokter-paramedis-umum', [RalanDokterParamedisUm::class, 'RalanDokterParamedisUm']);
    Route::get('/operasi-and-vk-umum', [OperasiAndVKUm::class, 'OperasiAndVKUm']);
    Route::get('/ranap-dokter-umum', [RanapDokterUm::class, 'RanapDokterUm']);
    Route::get('/ranap-paramedis-umum', [RanapParamedisUm::class, 'RanapParamedisUm']);
    Route::get('/ranap-dokter-paramedis-umum', [RanapDokterParamedisUm::class, 'RanapDokterParamedisUm']);
    Route::get('/periksa-radiologi-umum', [PeriksaRadiologiUm::class, 'PeriksaRadiologiUm']);

    // ANTRIAN PENDAFTARAN
    Route::get('/antrian-pendaftaran', [AntrianPendaftaran::class, 'AntrianPendaftaran'])->middleware('permision-rsbw:registrasi');
    Route::get('/cari-loket', [AntrianPendaftaran::class, 'DisplayAntrian'])->middleware('permision-rsbw:edit_registrasi');
    Route::get('/setting-antrian', [AntrianPendaftaran::class, 'SetingAntrian'])->middleware('permision-rsbw:edit_registrasi');

    // ANTRIAN POLI
    Route::get('/antrian-poli', [AntrianPoli::class, 'AntrianPoli']);
    Route::get('/display', [AntrianPoli::class, 'display']);
    Route::get('/panggil-poli', [AntrianPoli::class, 'panggilpoli']);
    Route::get('/setting-antrian-poli', [AntrianPoli::class, 'settingPoli']);
    Route::get('/jadwal-dokter', [BwJadwaldokter::class, 'BwJadwaldokter']);


    // RM
    Route::get('/berkas-rm', [BerkasRM::class, 'BerkasRM']);

    // KEPERAWATAN
    Route::get('/home-keperawatan', [HomeKeperawatan::class, 'HomeKeperawatan']);
    Route::get('/logbook-keperawatan', [PengawasKeperawatan::class, 'PengawasKeperawatan']);
    Route::get('/laporan-logbook-keperawatan', [LaporanLogBook::class, 'getLookBook']);
    Route::get('/laporan-logbook-keperawatan2', [LaporanLogBook2::class, 'getLookBook']);
    Route::get('/input-kegiatan-keperawatan-lain', [PengawasKeperawatan::class, 'InputKegiatanLain']);
    Route::get('/input-kegiatan-karu', [PengawasKeperawatan::class, 'InputKegiatankaru']);

    // BRIFING BPJS
    Route::get('/kirim-taskid-bpjs', [KirimTaskId::class, 'KirimTaskId']);
    Route::get('/sep-vclaim', [KirimTaskId::class, 'CariSepVclaim']);


});
    Route::get('/display-petugas', [AntrianPendaftaran::class, 'DisplayPetugas']);
});

