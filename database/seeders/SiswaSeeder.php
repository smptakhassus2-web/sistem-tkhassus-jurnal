<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\Rombel;
use App\Models\RombelSiswa;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        // Format: [Nama, NIPD, JK, NISN, Kelas, Tempat Lahir, Tanggal Lahir (Y-m-d), Alamat, RT, RW, Dusun, Kelurahan, Kecamatan, Kabupaten, Provinsi, Kode Pos]
        $siswaData = [
            // VII A (21 Siswa)
            ['ABDULLAH ALKAF', '2910', 'L', '0136366312', 'VII A', 'Wonosobo', '2013-12-06', 'Deroduwur', '2', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['AHMAD BAYU SETIYAWAN', '2911', 'L', '3134337170', 'VII A', 'Wonosobo', '2013-05-17', 'Deroduwur', '15', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['AHMAD MUSLIMIN', '2913', 'L', '0149515727', 'VII A', 'Wonosobo', '2014-06-21', 'Melikan', '7', '2', 'Melikan', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['AL CHOISAH', '2914', 'P', '3139939742', 'VII A', 'Wonosobo', '2013-08-09', 'Deroduwur', '16', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '13810'],
            ['ALFIYAH', '2915', 'P', '0138031200', 'VII A', 'Wonosobo', '2013-08-29', 'Melikan', '4', '2', 'Melikan', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['AMELIA', '2917', 'P', '0136931033', 'VII A', 'Banjarnegara', '2013-04-29', 'Semangkung', '3', '2', 'Semangkung', 'Semangkung', 'Kec. Pejawaran', 'Kab. Banjarnegara', 'Jawa Tengah', '53454'],
            ['ARYANUR QIROM', '2919', 'L', '0138605806', 'VII A', 'Jakarta', '2013-04-03', 'Sidamukti', '1', '4', 'Sukamaju', 'Sukamaju', 'Kec. Cilodong', 'Kota Depok', 'Jawa Barat', '16415'],
            ['ASYIFA KHUSNUL KHOTIMAH', '2920', 'P', '0143498776', 'VII A', 'Wonosobo', '2014-06-18', 'Melikan', '4', '2', 'Melikan', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['DZIKRO \'AINUL YAKIN', '2923', 'L', '0125635788', 'VII A', 'Wonosobo', '2012-11-25', 'Sambon', '9', '6', 'Sambon', 'Sumberdalem', 'Kec. Kertek', 'Kab. Wonosobo', 'Jawa Tengah', '56371'],
            ['HAF DLA LAFISA', '2925', 'P', '0133635402', 'VII A', 'Wonosobo', '2013-06-26', 'Deroduwur', '17', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['HARUUN SADINURHIKMA', '2960', 'L', '0133119634', 'VII A', 'Wonosobo', '2013-06-04', 'Krinjing', '26', '5', 'Krinjing', 'Krinjing', 'Kec. Watumalang', 'Kab. Wonosobo', 'Jawa Tengah', '56352'],
            ['KHAILA AZZUHRO', '2927', 'P', '0149716145', 'VII A', 'Wonosobo', '2014-04-07', 'Melikan', '1', '2', 'Melikan', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['LAILATUL ZABANIYAH', '2928', 'P', '0135594376', 'VII A', 'Wonosobo', '2013-02-22', 'Deroduwur', '17', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['MUHAMMAD IQBAL KHOIRURRIZA', '2933', 'L', '0131921703', 'VII A', 'Wonosobo', '2013-08-14', 'Deroduwur', '10', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['MUHAMMAD TSABIT AL \'AZMI', '2934', 'L', '0147851536', 'VII A', 'Wonosobo', '2014-05-01', 'Kleyang Jurang', '13', '1', 'Kleyang Jurang', 'Pungangan', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['NADIYA RIYANTIKA', '2935', 'P', '0141140566', 'VII A', 'Wonosobo', '2014-01-16', 'Melikan', '7', '2', 'Melikan', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['NAJIB TAUFIQUR ROHMAN', '2937', 'L', '3138384229', 'VII A', 'Wonosobo', '2013-11-22', 'Sojokerto', '1', '8', 'Sojokerto', 'Sojokerto', 'Kec. Leksono', 'Kab. Wonosobo', 'Jawa Tengah', '56362'],
            ['NURIN KHALISATUS ZALIFAH', '2941', 'P', '3137534383', 'VII A', 'Wonosobo', '2013-09-28', 'Deroduwur', '2', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['REZA ADITYA NUGRAHA', '2943', 'L', '3136505670', 'VII A', 'Brebes', '2013-10-22', 'Mojotengah', '3', '3', 'Mojotengah', 'Mojosari', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['UMI DWI SYAFANA', '2947', 'P', '0138959575', 'VII A', 'Wonosobo', '2013-02-17', 'Deroduwur', '14', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56532'],
            ['ZAIN ZHA ALBA', '2949', 'L', '0131205480', 'VII A', 'Wonosobo', '2013-06-13', 'Deroduwur', '20', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],

            // VII B (22 Siswa)
            ['\'AZIZAH NURJANNAH', '2958', 'P', '0141555500', 'VII B', 'Wonosobo', '2014-03-10', 'Banjarrgede', '1', '1', 'Banjargede', 'Banjar', 'Kec. Kertek', 'Kab. Wonosobo', 'Jawa Tengah', '56371'],
            ['AHMAD FIKRI', '2912', 'L', '3147040347', 'VII B', 'Wonosobo', '2014-03-07', 'Deroduwur', '6', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['ALFIATUS SA\'DIYAH', '2916', 'P', '3136136126', 'VII B', 'Wonosobo', '2013-11-12', 'Deroduwur', '16', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['ARDIKA NUR HELMAN', '2918', 'L', '0139199628', 'VII B', 'Wonosobo', '2013-07-30', 'Deroduwur', '12', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['AZKA NURDIANSYAH', '2921', 'L', '0133963052', 'VII B', 'Wonosobo', '2013-07-26', 'Pagedangan', '14', '6', 'Pagedangan', 'Wonokampir', 'Kec. Watumalang', 'Kab. Wonosobo', 'Jawa Tengah', '56352'],
            ['DAFID CHOIRUL FACHMI', '2922', 'L', '3131490700', 'VII B', 'Purworejo', '2013-12-11', 'Kedung Agung', '2', '2', 'Ketosari', 'Ketosari', 'Kec. Bener', 'Kab. Purworejo', 'Jawa Tengah', '54184'],
            ['FERDI KURNIA PUTRA', '2924', 'L', '3156689906', 'VII B', 'Purworejo', '2013-08-28', 'Kedung Agung', '1', '2', 'Kedung Agung', 'Ketosari', 'Kec. Bener', 'Kab. Purworejo', 'Jawa Tengah', '54183'],
            ['IFNA MAULIDA', '2926', 'P', '0134847889', 'VII B', 'Wonosobo', '2013-10-31', 'Bulu Lawang', '3', '4', 'Bulu Lawang', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['LAILATUN HASANAH', '2929', 'P', '0144093786', 'VII B', 'Wonosobo', '2014-04-29', 'Melikan', '7', '2', 'Melikan', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['LINA AMELIA', '2930', 'P', '0132855636', 'VII B', 'Wonosobo', '2013-10-16', 'Bulu Lawang', '1', '4', 'Bulu Lawang', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['LUFIYANA', '2931', 'P', '0146724974', 'VII B', 'Wonosobo', '2014-01-05', 'Melikan', '7', '2', 'Melikan', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['MUHAMAD ARSYAD ALBANJARI', '2932', 'L', '3136091690', 'VII B', 'Banjarnegara', '2013-09-19', 'Mojosari', '2', '3', 'Mojosari', 'Mojosari', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['NAFISA NUR HASANAH', '2936', 'P', '0149195445', 'VII B', 'Wonosobo', '2014-03-28', 'Melikan', '6', '2', 'Melikan', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['NAJLA NAZILATUNNADA', '2938', 'P', '3139256200', 'VII B', 'Wonosobo', '2014-06-30', 'Deroduwur', '2', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['NUR ALIFAH', '2939', 'P', '0141390696', 'VII B', 'Wonosobo', '2014-02-08', 'Melikan', '6', '2', 'Melikan', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['NUR ISTA DWI CHAITRA', '2940', 'P', '3142728430', 'VII B', 'Wonosobo', '2014-04-04', 'Mojotengah', '2', '3', 'Mojotengah', 'Mojosari', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '50356'],
            ['RIZAL KURNIAWAN', '2944', 'L', '0143769193', 'VII B', 'Wonosobo', '2014-04-14', 'Buntu', '1', '3', 'Buntu', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['ROIHANI FAIZAH', '2945', 'P', '3146753909', 'VII B', 'Wonosobo', '2014-05-30', 'Tawengan', '4', '4', 'Tawengan', 'Derongisor', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '50356'],
            ['RUKIYAH', '2946', 'P', '0132266781', 'VII B', 'Wonosobo', '2013-07-29', 'Melikan', '1', '2', 'Melikan', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['TEGAR', '2942', 'L', '0136428098', 'VII B', 'Banjarnegara', '2013-09-15', 'Babadan', '1', '5', 'Babadan', 'Babadan', 'Kec. Pagentan', 'Kab. Banjarnegara', 'Jawa Tengah', '53455'],
            ['ZAHWA NAZILATUN NISA', '2948', 'P', '0144347221', 'VII B', 'Wonosobo', '2014-06-25', 'Melikan', '7', '2', 'Melikan', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['ZIKRO MAULIDI AHMAD', '2950', 'L', '0134392779', 'VII B', 'Wonosobo', '2013-02-05', 'Sambon', '7', '5', 'Sambon', 'Sumberdalem', 'Kec. Kertek', 'Kab. Wonosobo', 'Jawa Tengah', '56371'],

            // VIII A (19 Siswa)
            ['AFNITA', '2855', 'P', '3126654857', 'VIII A', 'Wonosobo', '2012-08-05', 'Deroduwur', '14', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['AHMAD REZA ARDIAN', '2858', 'L', '3127363689', 'VIII A', 'Wonosobo', '2012-11-14', 'Gumawang', '3', '7', 'Gumawang', 'Krinjing', 'Kec. Watumalang', 'Kab. Wonosobo', 'Jawa Tengah', '56352'],
            ['ANNISATUL AZIFAH', '2860', 'P', '0122963934', 'VIII A', 'Wonosobo', '2012-12-17', 'Deroduwur', '7', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['CHUSNA AMALINA', '2863', 'P', '0127919544', 'VIII A', 'Wonosobo', '2012-09-24', 'Deroduwur', '4', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['ELISA RIZKIANA', '2865', 'P', '3126228037', 'VIII A', 'Wonosobo', '2012-09-05', 'Melikan', '6', '2', 'Melikan', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['ERWIN JUNIYANTO', '2866', 'L', '0128493502', 'VIII A', 'Wonosobo', '2012-06-08', 'Lingkar Marong', '11', '7', 'Ngariman', 'Purwojati', 'Kec. Kertek', 'Kab. Wonosobo', 'Jawa Tengah', '56371'],
            ['FA\'IZ ARIKA ZULFA', '2868', 'P', '0128929989', 'VIII A', 'Wonosobo', '2012-10-06', 'Deroduwur', '10', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['FEBRIANTI NUR HAMDANI', '2869', 'P', '3139739196', 'VIII A', 'Wonosobo', '2013-06-13', 'Melikan', '1', '2', 'Melikan', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['FITRIA SILVI AZZAHRA', '2870', 'P', '0124204150', 'VIII A', 'Wonosobo', '2012-08-27', 'Gondang', '5', '1', 'Gondang', 'Candimulyo', 'Kec. Kertek', 'Kab. Wonosobo', 'Jawa Tengah', '56371'],
            ['MAJID USMAN', '2877', 'L', '0124767340', 'VIII A', 'Wonosobo', '2012-06-08', 'Gedangsari', '10', '5', 'Gedangsari', 'Wonokampir', 'Kec. Watumalang', 'Kab. Wonosobo', 'Jawa Tengah', '56352'],
            ['MAKRIFATUN HASANAH', '2878', 'P', '0121424979', 'VIII A', 'Wonosobo', '2012-05-06', 'Tempel', '2', '10', 'Tempel', 'Kalikarung', 'Kec. Kalibawang', 'Kab. Wonosobo', 'Jawa Tengah', '56375'],
            ['MUHAMMAD NADIF ADICANDRA', '2876', 'L', '3127954817', 'VIII A', 'Wonosobo', '2012-04-22', 'Pekaringan', '1', '1', 'Pekaringan', 'Larangan Kulon', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['NOVITA SARI', '2883', 'P', '3122382736', 'VIII A', 'Wonosobo', '2012-11-12', 'Kalidesel', '2', '3', 'Kalidesel', 'Kalidesel', 'Kec. Watumalang', 'Kab. Wonosobo', 'Jawa Tengah', '56352'],
            ['QAILA RAFEEFA', '2885', 'P', '0124925191', 'VIII A', 'Wonosobo', '2012-09-06', 'Deroduwur', '19', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['QURROTUL AMIRA', '2886', 'P', '0123265303', 'VIII A', 'Wonosobo', '2012-09-10', 'Lobang', '4', '3', 'Lobang', 'Surengede', 'Kec. Kejajar', 'Kab. Wonosobo', 'Jawa Tengah', '56354'],
            ['RISMA NUR EKA SEPTIANA', '2951', 'P', '0134587394', 'VIII A', 'Wonosobo', '2013-09-01', 'Rejosari', '16', '3', 'Rejosari', 'Krinjing', 'Kec. Watumalang', 'Kab. Wonosobo', 'Jawa Tengah', '56352'],
            ['SERLIN', '2888', 'P', '3133139274', 'VIII A', 'Wonosobo', '2013-07-16', 'Tawengan', '4', '4', 'Derongisor', 'Derongisor', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['SOFA RIYAWAN', '2890', 'L', '3127441909', 'VIII A', 'Wonosobo', '2012-09-03', 'Doleg', '1', '4', 'Doleg', 'Ngadikerso', 'Kec. Sapuran', 'Kab. Wonosobo', 'Jawa Tengah', '56373'],
            ['ZAAKIYAH KHAIRUN NISA', '2891', 'P', '3137913814', 'VIII A', 'Wonosobo', '2013-08-09', 'Tawengan', '4', '3', 'Tawengan', 'Derongisor', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],

            // VIII B (14 Siswa)
            ['AHMAD FAIRUZ ASYROF', '2856', 'L', '0128527841', 'VIII B', 'Wonosobo', '2012-05-11', 'Deroduwur', '17', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['AISYA AZZAHRA', '2859', 'P', '3129255086', 'VIII B', 'Wonosobo', '2012-04-29', 'Mekarsari', '4', '1', 'Mekarsari', 'Kalibeber', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['ARUNA ASYA ANGGRAENI', '2861', 'P', '3129028558', 'VIII B', 'Wonosobo', '2012-06-22', 'Argasoka', '2', '7', 'Argasoka', 'Argasoka', 'Kec. Banjarnegara', 'Kab. Banjarnegara', 'Jawa Tengah', '53418'],
            ['CAHYA LUTFI SARI', '2862', 'P', '3138848362', 'VIII B', 'Magelang', '2013-02-12', 'Krandegan', '13', '7', 'Krandegan', 'Sukomakmur', 'Kec. Kajoran', 'Kab. Magelang', 'Jawa Tengah', '56163'],
            ['KAFA BILLAH', '2873', 'L', '0123768473', 'VIII B', 'Wonosobo', '2012-09-02', 'Andongsili', '5', '2', 'Andongsili', 'Andongsili', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['KHANZA FIARENZA HAFIDZAH', '2874', 'P', '3128798804', 'VIII B', 'Wonosobo', '2012-08-07', 'Deroduwur', '10', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['LARISA NADIFA NURPASHA', '2875', 'P', '3121709819', 'VIII B', 'Wonosobo', '2012-07-30', 'Deroduwur', '18', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['NGA\'IDA NAJMA QUMAILA', '2880', 'P', '0123979947', 'VIII B', 'Wonosobo', '2012-10-25', 'Deroduwur', '1', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['NOVITA', '2882', 'P', '3121981143', 'VIII B', 'Wonosobo', '2012-11-05', 'Deroduwur', '2', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['NUR AFIFAH KHASANAH', '2884', 'P', '3135135371', 'VIII B', 'Wonosobo', '2013-05-14', 'Deroduwur', '3', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['RADIT', '2887', 'L', '0124622745', 'VIII B', 'Wonosobo', '2012-06-26', 'Deroduwur', '1', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['SILVIANA MUTIARA RAMADANI', '2889', 'P', '0133186503', 'VIII B', 'Wonosobo', '2013-07-07', 'Deroduwur', '7', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['ZAHRATU HAFIZAH', '2894', 'P', '0131379312', 'VIII B', 'Wonosobo', '2013-07-11', 'Tripis', '12', '6', 'Tripis', 'Watumalang', 'Kec. Watumalang', 'Kab. Wonosobo', 'Jawa Tengah', '56352'],
            ['ZIDAN MAULANA', '2892', 'L', '0135244746', 'VIII B', 'Wonosobo', '2013-01-28', 'Deroduwur', '2', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],

            // IX A (28 Siswa)
            ['ABDUL NASIR', '2806', 'L', '3115069044', 'IX A', 'Semarang', '2011-09-22', 'Sendangguwo', '7', '1', 'Sendangguwo', 'Sendangguwo', 'Kec. Tembalang', 'Kota Semarang', 'Jawa Tengah', '50273'],
            ['ALKHA RIZKY ADINATA SUBRATA', '2740', 'L', '0128587311', 'IX A', 'Boyolali', '2012-01-30', 'Deroduwur', '17', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['ANA MASRUROH', '2742', 'P', '3128222579', 'IX A', 'Wonosobo', '2012-07-29', 'Tawengan', '4', '4', 'Tawengan', 'Derongisor', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['ANNGGITA NAULY NI\'MA', '2744', 'P', '0122235187', 'IX A', 'Magelang', '2012-05-10', 'Krandegan', '16', '8', 'Krandegan', 'Sukomakmur', 'Kec. Kajoran', 'Kab. Magelang', 'Jawa Tengah', '56163'],
            ['ASMAUL RIZKILLAH', '2746', 'L', '3118490696', 'IX A', 'Wonosobo', '2011-08-30', 'Gumawang', '4', '8', 'Gumawang', 'Krinjing', 'Kec. Watumalang', 'Kab. Wonosobo', 'Jawa Tengah', '56352'],
            ['AULINA SYIFA', '2747', 'P', '3112067718', 'IX A', 'Wonosobo', '2011-04-27', 'Sojokerto', '1', '8', 'Sojokerto', 'Sojokerto', 'Kec. Leksono', 'Kab. Wonosobo', 'Jawa Tengah', '56360'],
            ['AYU SETYA NINGRUM', '2748', 'P', '0115343798', 'IX A', 'Wonosobo', '2011-06-06', 'Pagedangan', '17', '7', 'Pagedangan', 'Wonokampir', 'Kec. Watumalang', 'Kab. Wonosobo', 'Jawa Tengah', '56352'],
            ['AZKA ABDILLAH', '2750', 'L', '0129821283', 'IX A', 'Wonosobo', '2012-04-30', 'Deroduwur', '15', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['CHIKA SYAFIRA', '2753', 'P', '0117511731', 'IX A', 'Magelang', '2011-04-24', 'Krandegan', '12', '7', 'Krandegan', 'Sukomakmur', 'Kec. Kajoran', 'Kab. Magelang', 'Jawa Tengah', '56163'],
            ['DIKA MUSLIMIN', '2754', 'L', '0106263488', 'IX A', 'Wonosobo', '2010-10-21', 'Deroduwur', '13', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['EFTIAN', '2759', 'L', '0125252663', 'IX A', 'Wonosobo', '2012-07-19', 'Bululawang', '2', '4', 'Bululawang', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['FATIKHATUS SOLIKHAH', '2762', 'P', '0127698425', 'IX A', 'Wonosobo', '2011-09-25', 'Pagedangan', '14', '6', 'Pagedangan', 'Wonokampir', 'Kec. Watumalang', 'Kab. Wonosobo', 'Jawa Tengah', '56352'],
            ['KHUSNA FATIMATUN NISA', '2767', 'P', '3112975871', 'IX A', 'Wonosobo', '2011-12-17', 'Kalibeber', '1', '7', 'Kalibeber', 'Kalibeber', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56349'],
            ['KURNIA SEPTIANI', '2768', 'P', '0112284749', 'IX A', 'Wonosobo', '2011-09-22', 'Jln.Parakan No 78', '8', '2', 'Gondang', 'Candimulyo', 'Kec. Kertek', 'Kab. Wonosobo', 'Jawa Tengah', '56346'],
            ['LAILI MAHFIROH', '2769', 'P', '0128302902', 'IX A', 'Wonosobo', '2012-07-02', 'Melikan', '4', '2', 'Melikan', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['LALA ROFIANA PUTRI', '2770', 'P', '0123385141', 'IX A', 'Magelang', '2012-03-20', 'Krandegan', '8', '6', 'Krandegan', 'Sukomakmur', 'Kec. Kajoran', 'Kab. Magelang', 'Jawa Tengah', '56163'],
            ['MOHAMAD SARIF', '2773', 'L', '0116814432', 'IX A', 'Wonosobo', '2011-08-04', 'Deroduwur', '2', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56348'],
            ['MUHAMAD IBNU SAHAL', '2774', 'L', '0123128592', 'IX A', 'Wonosobo', '2012-05-10', 'Deroduwur', '1', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['MUHAMMAD FAATKHUL IZZY', '2775', 'L', '0118027080', 'IX A', 'Wonosobo', '2011-09-08', 'Gondang', '10', '2', 'Candimulyo', 'Candimulyo', 'Kec. Kertek', 'Kab. Wonosobo', 'Jawa Tengah', '56371'],
            ['NASYA RAHMADINA', '2780', 'P', '0125460784', 'IX A', 'Wonosobo', '2012-06-08', 'Bululawang', '4', '4', 'Bululawang', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['NUR KHOIRUL RIFKI', '2783', 'L', '0117455300', 'IX A', 'Wonosobo', '2011-12-24', 'Deroduwur', '1', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['NUR MUHAMMAD AUFA ALFARUQ', '2784', 'L', '0125606943', 'IX A', 'Wonosobo', '2012-06-30', 'Dawuhan', '3', '2', 'Kayugiyang', 'Kayugiyang', 'Kec. Garung', 'Kab. Wonosobo', 'Jawa Tengah', '56353'],
            ['RAFKA PUTRA MAULANA', '2787', 'L', '0119197877', 'IX A', 'Wonosobo', '2011-11-07', 'Deroduwur', '11', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['RIYANTI', '2790', 'P', '0123432237', 'IX A', 'Wonosobo', '2012-03-28', 'Melikan', '7', '2', 'Melikan', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['ROHMAT ADITIYA', '2791', 'L', '3122466757', 'IX A', 'Wonosobo', '2012-08-30', 'Tawengan', '2', '4', 'Tawengan', 'Derongisor', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['SAFIRA YULFIANA IZATI', '2793', 'P', '0128782329', 'IX A', 'Wonosobo', '2012-05-03', 'Buntu', '2', '3', 'Buntu', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['SATRIA AKBAR AL GHIFARI', '2795', 'L', '0129431300', 'IX A', 'Wonosobo', '2012-04-09', 'Deroduwur', '10', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['ULIL MAHFIROH', '2799', 'P', '0125793537', 'IX A', 'Wonosobo', '2012-06-03', 'Melikan', '4', '2', 'Melikan', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],

            // IX B (24 Siswa)
            ['ADELIA RISKA SARI', '2737', 'P', '0113418799', 'IX B', 'Magelang', '2011-03-29', 'Krandegan', '13', '7', 'Krandegan', 'Sukomakmur', 'Kec. Kajoran', 'Kab. Magelang', 'Jawa Tengah', '56163'],
            ['AHMAD CAHYO', '2738', 'L', '0102099574', 'IX B', 'Temanggung', '2010-09-28', 'Deroduwur', '2', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56348'],
            ['ANDY ASZUWARI JANTO', '2743', 'L', '0127949160', 'IX B', 'Wonosobo', '2012-01-02', 'Deroduwur', '1', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['CALLYSTA DEANA ALFAN', '2752', 'P', '3120457984', 'IX B', 'Wonosobo', '2012-01-02', 'Kebondalem', '4', '4', 'Sukorejo', 'Sukorejo', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['DUROTUN NAFISAH', '2805', 'P', '0123823962', 'IX B', 'Wonosobo', '2012-05-23', 'Deroduwur', '16', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['HELDI TRI MANDELA', '2763', 'L', '0111168807', 'IX B', 'Wonosobo', '2011-12-14', 'Deroduwur', '15', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['MAUREN ANGELINA', '2771', 'P', '0123715327', 'IX B', 'Wonosobo', '2012-03-18', 'Deroduwur', '10', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['MOHAMAD NADZIF ZUHRI', '2772', 'L', '0114986606', 'IX B', 'Wonosobo', '2011-11-05', 'Deroduwur', '5', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['MUHAMMAD MAVAIL MU\'AFA', '2776', 'L', '0108059785', 'IX B', 'Wonosobo', '2010-10-24', 'Citralangu', '2', '2', 'Citralangu', 'Grugu', 'Kec. Kaliwiro', 'Kab. Wonosobo', 'Jawa Tengah', '56318'],
            ['MUNIFFATUL KHUSNA', '2808', 'P', '3129373202', 'IX B', 'Purworejo', '2012-07-01', 'Kedung Agung Bawah', '1', '2', 'Ketosari', 'Ketosari', 'Kec. Bener', 'Kab. Purworejo', 'Jawa Tengah', '54183'],
            ['NANDA PRAWIRA DHARMA', '2779', 'L', '0119017386', 'IX B', 'Wonosobo', '2011-11-11', 'Deroduwur', '19', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['NAYLA MUDRIKAH', '2781', 'P', '0113706049', 'IX B', 'Magelang', '2012-04-11', 'Krandegan', '6', '6', 'Krandegan', 'Sukomakmur', 'Kec. Kajoran', 'Kab. Magelang', 'Jawa Tengah', '56163'],
            ['NIDAUL HUSNA', '2782', 'P', '3116665533', 'IX B', 'Wonosobo', '2012-02-14', 'Pukiran', '1', '1', 'Ngalian', 'Ngalian', 'Kec. Wadaslintang', 'Kab. Wonosobo', 'Jawa Tengah', '56365'],
            ['OKA FEBRIYAN', '2785', 'P', '0115336081', 'IX B', 'Wonosobo', '2011-10-29', 'Pagedangan', '15', '7', 'Pagedangan', 'Wonokampir', 'Kec. Watumalang', 'Kab. Wonosobo', 'Jawa Tengah', '56352'],
            ['PUTRI CAHYONI RAHMADANI', '2786', 'P', '0107888112', 'IX B', 'Merauke', '2010-07-30', 'Gondang', '3', '1', 'Gondang', 'Candimulyo', 'Kec. Kertek', 'Kab. Wonosobo', 'Jawa Tengah', '56371'],
            ['RAMADIKA KURNIA CHANDRA', '2788', 'L', '3121308260', 'IX B', 'Wonosobo', '2012-08-17', 'Tawengan', '1', '4', 'Tawengan', 'Derongisor', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['ROUF KHOIRUDIN', '2792', 'L', '0119044444', 'IX B', 'Wonosobo', '2011-07-06', 'Pagedangan', '17', '7', 'Pagedangan', 'Wonokampir', 'Kec. Watumalang', 'Kab. Wonosobo', 'Jawa Tengah', '56352'],
            ['SAIPUL', '2794', 'L', '0111980658', 'IX B', 'Wonosobo', '2011-09-22', 'Deroduwur', '4', '1', 'Deroduwur', 'Deroduwur', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['SEPTI SAFITRI', '2796', 'P', '3126252836', 'IX B', 'Wonosobo', '2012-09-15', 'Tawengan', '3', '4', 'Tawengan', 'Derongisor', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['SEPTIYANA TADZKIROH', '2797', 'P', '3119145597', 'IX B', 'Wonosobo', '2011-09-15', 'Mojotengah', '4', '4', 'Mojotengah', 'Mojosari', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['SHAFARA AMELIA', '2833', 'P', '3111413095', 'IX B', 'Wonosobo', '2011-06-05', 'Mekarsari', '6', '13', 'Memkarsari', 'Kalibeber', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56350'],
            ['WAHID AR-ROKHMAN', '2801', 'L', '0114421939', 'IX B', 'Cilacap', '2011-10-28', 'Tambangan', '1', '2', 'Bulupayung', 'Bulupayung', 'Kec. Kesugihan', 'Kab. Cilacap', 'Jawa Tengah', '53274'],
            ['WIDI WAFROTUNNAFISAH', '2802', 'P', '3110831939', 'IX B', 'Wonosobo', '2011-07-19', 'Serang', '4', '3', 'Serang', 'Derongisor', 'Kec. Mojotengah', 'Kab. Wonosobo', 'Jawa Tengah', '56351'],
            ['ZUKHROTUL LAELY', '2804', 'P', '0128418329', 'IX B', 'Wonosobo', '2012-01-25', 'Limbangan', '11', '3', 'Limbangan', 'Pucungkerep', 'Kec. Kaliwiro', 'Kab. Wonosobo', 'Jawa Tengah', '56364'],
        ];

        $countSiswa = 0;
        $countRombel = 0;

                foreach ($siswaData as $data) {
            // 1. Simpan atau Update Data Siswa Lengkap
            $siswa = Siswa::updateOrCreate(
                ['nisn' => $data[3]], 
                [
                    'nipd' => $data[1],
                    'nama' => $data[0],
                    'jenis_kelamin' => $data[2],
                    'tempat_lahir' => $data[5],
                    'tanggal_lahir' => $data[6],
                    'alamat' => $data[7],
                    'rt' => $data[8],
                    'rw' => $data[9],
                    'dusun' => $data[10],
                    'kelurahan' => $data[11],
                    'kecamatan' => $data[12],
                    'kabupaten' => $data[13],
                    'provinsi' => $data[14],
                    'kode_pos' => $data[15],
                ]
            );
            $countSiswa++;

            // 2. PERBAIKAN: Mapping Kelas dari Excel (Romawi) ke Database (Angka)
            $mapKelas = [
                'VII A' => '7A', 'VII B' => '7B',
                'VIII A' => '8A', 'VIII B' => '8B',
                'IX A' => '9A', 'IX B' => '9B',
            ];
            $dbKelasCode = $mapKelas[$data[4]] ?? $data[4];
            
            $rombel = Rombel::where('kode', $dbKelasCode)->first();
            if ($rombel) {
                RombelSiswa::updateOrCreate(
                    ['siswa_id' => $siswa->id, 'rombel_id' => $rombel->id],
                    ['tahun_ajaran' => '2026/2027']
                );
                $countRombel++;
            }
        }
        $this->command->info("✅ Berhasil memasukkan {$countSiswa} data siswa lengkap dan {$countRombel} relasi ke rombel.");
    }
}