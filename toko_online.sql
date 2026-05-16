-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2026 at 10:34 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_online`
--

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `email_pelanggan` varchar(100) NOT NULL,
  `password_pelanggan` varchar(100) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `telepon_pelanggan` varchar(25) NOT NULL,
  `alamat_pelanggan` text NOT NULL,
  `foto_profile` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `email_pelanggan`, `password_pelanggan`, `nama_pelanggan`, `telepon_pelanggan`, `alamat_pelanggan`, `foto_profile`) VALUES
(1, 'andika77@gmail.com', 'andika', 'putri amalia ramadani', '0845372932', 'cukanggalih', NULL),
(2, 'cindi@gmai.com', 'cindi22', 'cindi setio', '4567890998976', 'batuceper', NULL),
(3, 'putri@gmail.com', 'sofiatun', 'PUTRI SOFIATUN MUZOFAR', '090807060504', 'karawaci', 'profile_1778158832.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `id_customer` int(50) NOT NULL,
  `nama_customer` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `no_hp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`id_customer`, `nama_customer`, `email`, `no_hp`) VALUES
(1, 'Athlas Wiratama', 'athlas1234@gmail.com', '082119176180'),
(2, 'Bulan Anindya  Saraswati', 'bulanninsas@gmail.com', '0821191161771'),
(3, 'Ceilo Wiratama', 'ceilo321@gmail.com', '082191906170'),
(4, 'Cinta Putri Wijaya', 'cinta777@gmail.com', '082117189723'),
(5, 'Elio W', 'elio888@gmail.com', '082119876521'),
(6, 'Avni', 'avnisaja@gmail.com', '082113176170'),
(7, 'Haris', 'harissss1@gmail.com', '082119187654'),
(8, 'Karina', 'karinaespa@gmail.com', '082113176621'),
(9, 'Tama', 'tama0618@gmail.com', '082118061005'),
(10, 'Aksara', 'aksaja@gmail.com', '082119111718'),
(26, 'ddawdawdaw', 'contoh@gmail.com', '08545345'),
(27, 'mahesaaganteng', 'mahesaibrahim@gmai.com', '084435345345'),
(28, 'raffi ahmad', 'raffinagita@gmail.com', '084234234'),
(29, 'Bulan Anindya Saraswati', 'bulanninsas@gmail.co', '082119116171'),
(34, 'adit', 'adit@gmailcom', '0821131416007'),
(35, 'Aleta Wijaya', 'letaleta@gmail.com', '082113145677'),
(36, 'Udin', 'udin@gmail.com', '085623415631'),
(38, 'cindi setio', 'cindi@gmail.com', '1234567890'),
(39, 'putri amalia ramadani', 'putr@gmail.com', '08123456789');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_detail_transaksi`
--

CREATE TABLE `tbl_detail_transaksi` (
  `id_detail` int(50) NOT NULL,
  `id_transaksi` int(50) NOT NULL,
  `id_produk` int(50) NOT NULL,
  `jumlah` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_detail_transaksi`
--

INSERT INTO `tbl_detail_transaksi` (`id_detail`, `id_transaksi`, `id_produk`, `jumlah`) VALUES
(18, 33, 14, 6),
(19, 33, 24, 11),
(20, 34, 16, 1),
(21, 34, 22, 1),
(22, 35, 34, 1),
(23, 36, 30, 4),
(25, 38, 13, 1),
(26, 39, 14, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kategori`
--

CREATE TABLE `tbl_kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_kategori`
--

INSERT INTO `tbl_kategori` (`id_kategori`, `nama`) VALUES
(2, 'Baju pria'),
(3, 'Baju wanita'),
(4, 'Sepatu'),
(5, 'Topi'),
(7, 'Hoodie'),
(8, 'Jam Tangan'),
(10, 'Tas Pria'),
(11, 'Tas Wanita');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_produk`
--

CREATE TABLE `tbl_produk` (
  `id` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `harga` double NOT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `ketersediaan_stok` enum('habis','tersedia') DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_produk`
--

INSERT INTO `tbl_produk` (`id`, `id_kategori`, `nama`, `harga`, `foto`, `detail`, `ketersediaan_stok`) VALUES
(12, 2, 'BLUE', 1755000, 'qqwJJHfpO1vOJAKt1met.jpeg', 'Sweater rajut pria dengan desain half zipper yang memberikan tampilan modern dan rapi. Terbuat dari bahan rajut berkualitas yang lembut, hangat, dan nyaman digunakan sepanjang hari. Tekstur rajut berpola menambah kesan elegan tanpa terlihat berlebihan. Cocok dipadukan dengan celana bahan atau chino untuk gaya casual hingga semi-formal.\r\n\r\nDetail Produk:\r\nModel: Sweater rajut half zip\r\nWarna: Biru muda\r\nBahan: Rajut premium\r\nKesan: Casual elegant\r\n\r\nCocok untuk: Hangout, kerja santai, acara semi formal', 'tersedia'),
(13, 2, 'CHOCO', 1880000, '8bFMlE1nBpHvbXUNGVCS.jpeg', 'Sweater rajut pria berwarna cokelat dengan potongan regular fit yang nyaman dipakai. Model resleting setengah leher memberikan kesan maskulin dan rapi. Bahan rajut tebal namun tetap breathable, cocok untuk aktivitas indoor maupun outdoor. Mudah dipadukan dengan celana warna netral dan sneakers.\r\n\r\nDetail Produk:\r\nModel: Half zip knit sweater\r\nWarna: Cokelat muda\r\nBahan: Rajut lembut &amp; hangat\r\nFit: Regular fit\r\n\r\nCocok untuk: Daily wear, meeting santai, casual outing', 'tersedia'),
(14, 2, 'WHITE', 2250000, 'CLgyPiNhPuC8XdCNXGul.jpeg', 'Jaket pria dengan desain simpel dan klasik yang cocok untuk berbagai gaya. Menggunakan bahan yang ringan namun tetap kokoh, nyaman digunakan sehari-hari. Warna krem memberikan kesan clean dan mudah dipadukan dengan berbagai outfit. Dilengkapi dengan kerah kontras yang menambah karakter pada tampilan.\r\n\r\nDetail Produk:\r\nModel: Jaket casual pria\r\nWarna: Krem dengan aksen cokelat\r\nBahan: Katun tebal\r\nKesan: Casual classic\r\n\r\nCocok untuk: Jalan santai, traveling, aktivitas harian', 'tersedia'),
(15, 3, 'LOOKS RED', 3777000, 'UhzhZ4Ny3shYhrSsbrjP.jpeg', 'Cardigan rajut wanita dengan desain feminin dan elegan. Memiliki potongan rapi yang nyaman digunakan untuk aktivitas formal maupun semi formal. Warna maroon memberikan kesan anggun dan dewasa. Cocok dipadukan dengan kemeja sebagai inner dan celana bahan untuk tampilan profesional.\r\n\r\nDetail Produk:\r\nModel: Cardigan knit wanita\r\nWarna: Maroon\r\nBahan: Rajut halus\r\nFit: Regular fit\r\n\r\nCocok untuk: Kerja, acara formal, meeting', 'tersedia'),
(16, 3, 'LOOKS BLACK', 2999999, 'ryP5dXnx70efpPSygXOG.jpeg', 'Kemeja panjang wanita dengan motif garis vertikal yang memberikan efek tubuh terlihat lebih jenjang. Terbuat dari bahan ringan dan nyaman dipakai seharian. Desain modern dengan potongan rapi menjadikan kemeja ini cocok untuk tampilan formal maupun smart casual.\r\n\r\nDetail Produk:\r\nModel: Long sleeve shirt\r\nMotif: Garis hitam-putih\r\nBahan: Katun halus\r\nKesan: Modern &amp; chic\r\n\r\nCocok untuk: Kantor, acara formal, business meeting', 'tersedia'),
(17, 3, 'LOOKS BLUE', 2599000, 'wV1SyLLaV22JjsFEzcdC.jpeg', 'Kemeja panjang wanita dengan motif garis vertikal yang memberikan efek tubuh terlihat lebih jenjang. Terbuat dari bahan ringan dan nyaman dipakai seharian. Desain modern dengan potongan rapi menjadikan kemeja ini cocok untuk tampilan formal maupun smart casual.\r\n\r\nDetail Produk:\r\nModel: Long sleeve shirt\r\nMotif: Garis biru-putih\r\nBahan: Katun halus\r\nKesan: Modern &amp; chic\r\n\r\nCocok untuk: Kantor, acara formal, business meeting', 'tersedia'),
(18, 7, 'URBAN VIBES CHOCO', 220000, 'EMKmjgcHKxGTyMjEo8bk.jpeg', 'Hoodie Confort dirancang untuk memberikan kenyamanan maksimal dengan tampilan simpel dan modern. Cocok untuk aktivitas santai maupun gaya sehari-hari.\r\n\r\nDetail Produk:\r\nBahan: Soft premium knitted fabric\r\nKomposisi: 80% cotton, 20% polyester\r\nTekstur: Lembut, hangat, dan nyaman dipakai seharian\r\n\r\nFitur:\r\nHoodie dengan tali serut\r\nKantong depan (kangaroo pocket)\r\nRib elastis pada bagian lengan dan bawah hoodie\r\nLogo patch minimalis di bagian dada\r\n\r\nFit &amp; Ukuran:\r\n42–48: Relaxed fit\r\n44–54: Full oversize fit\r\n\r\nKelebihan:\r\nMemberikan kehangatan ekstra tanpa terasa berat\r\nNyaman di kulit dan tidak mudah panas\r\nCocok untuk outfit casual, streetwear, dan daily wear\r\n\r\nWarna: Soft blue (sesuai gambar)\r\n\r\nKonsep Produk:\r\nLebih dari sekadar pakaian — hoodie ini adalah zona nyaman kamu untuk bergerak bebas dengan gaya yang effortless.', 'tersedia'),
(19, 7, 'JNRIVER WHITE', 277000, 'DAyHYDlHfY01xUE45GPW.jpeg', 'Hoodie Confort dirancang untuk memberikan kenyamanan maksimal dengan tampilan simpel dan modern. Cocok untuk aktivitas santai maupun gaya sehari-hari.\r\n\r\nDetail Produk:\r\nBahan: Soft premium knitted fabric\r\nKomposisi: 80% cotton, 20% polyester\r\nTekstur: Lembut, hangat, dan nyaman dipakai seharian\r\n\r\nFitur:\r\nHoodie dengan tali serut\r\nKantong depan (kangaroo pocket)\r\nRib elastis pada bagian lengan dan bawah hoodie\r\nLogo patch minimalis di bagian dada\r\n\r\nFit &amp; Ukuran:\r\n42–48: Relaxed fit\r\n44–54: Full oversize fit\r\n\r\nKelebihan:\r\nMemberikan kehangatan ekstra tanpa terasa berat\r\nNyaman di kulit dan tidak mudah panas\r\nCocok untuk outfit casual, streetwear, dan daily wear\r\n\r\nWarna: Soft blue (sesuai gambar)\r\n\r\nKonsep Produk:\r\nLebih dari sekadar pakaian — hoodie ini adalah zona nyaman kamu untuk bergerak bebas dengan gaya yang effortless.', 'tersedia'),
(20, 7, 'CONFORT BLUE', 278000, 'TGJbvOZ6oObBpiTDWnNO.jpeg', 'Hoodie Confort dirancang untuk memberikan kenyamanan maksimal dengan tampilan simpel dan modern. Cocok untuk aktivitas santai maupun gaya sehari-hari.\r\n\r\nDetail Produk:\r\nBahan: Soft premium knitted fabric\r\nKomposisi: 80% cotton, 20% polyester\r\nTekstur: Lembut, hangat, dan nyaman dipakai seharian\r\n\r\nFitur:\r\nHoodie dengan tali serut\r\nKantong depan (kangaroo pocket)\r\nRib elastis pada bagian lengan dan bawah hoodie\r\nLogo patch minimalis di bagian dada\r\n\r\nFit &amp; Ukuran:\r\n42–48: Relaxed fit\r\n44–54: Full oversize fit\r\n\r\nKelebihan:\r\nMemberikan kehangatan ekstra tanpa terasa berat\r\nNyaman di kulit dan tidak mudah panas\r\nCocok untuk outfit casual, streetwear, dan daily wear\r\n\r\nWarna: Soft blue (sesuai gambar)\r\n\r\nKonsep Produk:\r\nLebih dari sekadar pakaian — hoodie ini adalah zona nyaman kamu untuk bergerak bebas dengan gaya yang effortless.', 'tersedia'),
(22, 4, 'URBAN TERRA CLASSIC SNEAKRERS', 500000, 'wEluBjKKGz1XHyO02tZb.jpg', 'Sneakers dengan desain klasik yang dipadukan sentuhan modern, memberikan tampilan stylish namun tetap timeless. Menggunakan material suede dan mesh berkualitas yang nyaman dipakai sepanjang hari. Warna krem berpadu dengan aksen cokelat menciptakan kesan hangat dan elegan, mudah dipadukan dengan berbagai outfit kasual hingga smart casual. Sol tebal yang kokoh memberikan kenyamanan ekstra sekaligus menunjang aktivitas harian.\r\n\r\nDetail Produk:\r\nModel: Sneakers low-top\r\nWarna: Krem dengan aksen cokelat\r\nBahan: Suede &amp; mesh premium\r\nSol: Karet tebal anti-slip\r\nKesan: Casual classic &amp; modern\r\n\r\nCocok untuk: Daily wear, hangout, traveling, gaya kasual rapi', 'tersedia'),
(23, 5, 'DOHENY BOYZ SIGNATURE CAP', 300000, 'TIzTH6aV42y28DIqPT2P.jpg', 'Topi baseball dengan desain minimalis dan karakter kuat, cocok untuk melengkapi gaya kasual hingga streetwear. Terbuat dari bahan suede/katun berkualitas yang lembut namun tetap kokoh, nyaman digunakan seharian. Warna cokelat mustard memberikan kesan hangat, earthy, dan mudah dipadukan dengan berbagai outfit. Logo patch “Doheny Boyz” di bagian depan menjadi statement simpel namun berkelas.\r\n\r\nDetail Produk:\r\nModel: Baseball cap\r\nWarna: Cokelat mustard\r\nBahan: Katun suede premium\r\nDetail: Logo patch bordir\r\nKesan: Casual street &amp; modern\r\n\r\nCocok untuk: Daily wear, hangout, traveling, street style', 'tersedia'),
(24, 8, 'RADO CHRONO WATCH', 10000000, 'A0BU0wo8crspEGS7Fo5a.jpg', 'Jam tangan dengan desain mewah dan presisi tinggi yang memadukan estetika modern dengan sentuhan klasik. Dial hitam dengan detail chronograph memberikan tampilan tegas dan maskulin, sementara material stainless steel berwarna hitam menghadirkan kesan eksklusif dan profesional. Mesin automatic memastikan performa akurat tanpa perlu baterai, cocok untuk menunjang gaya hidup aktif dan berkelas.\r\n\r\nDetail Produk:\r\nModel: Jam tangan chronograph automatic\r\nWarna: Hitam full black\r\nMaterial strap: Stainless steel\r\nDial: Hitam dengan sub-dial chronograph\r\nKesan: Luxury modern &amp; masculine\r\n\r\nCocok untuk: Acara formal, business meeting, daily executive wear, koleksi jam premium', 'tersedia'),
(25, 4, 'VANS CHECKERBOARD CLASSIC SLIP-ON', 800000, 'vWEeoUNKsNxW7huYdTNC.jpg', 'Sepatu ikonik dengan motif catur hitam-putih yang timeless dan langsung memberikan statement pada penampilan. Desain slip-on khas Vans memudahkan pemakaian sekaligus menghadirkan gaya kasual yang santai namun tetap stylish. Terbuat dari kanvas berkualitas dengan sol karet waffle yang nyaman dan anti-slip, cocok digunakan untuk aktivitas sehari-hari.\r\n\r\nDetail Produk:\r\nModel: Slip-on sneakers\r\nMotif: Checkerboard hitam-putih\r\nBahan: Canvas premium\r\nSol: Karet waffle khas Vans\r\nKesan: Casual iconic &amp; street style\r\n\r\nCocok untuk: Daily wear, hangout, skate casual, streetwear look', 'tersedia'),
(26, 4, 'NIKE DUNK HIGH GOLDEN ORANGE', 5000000, 'enYRB9QfOYw8p5Jd4E3E.jpg', 'Sneakers high-top dengan desain ikonik yang memadukan nuansa klasik dan street style modern. Perpaduan warna beige dan golden orange memberikan tampilan standout namun tetap elegan. Terbuat dari material kulit berkualitas yang kokoh dan nyaman dipakai sepanjang hari. Siluet high-top memberikan dukungan ekstra sekaligus memperkuat karakter sporty yang bold.\r\n\r\nDetail Produk:\r\nModel: High-top sneakers\r\nWarna: Beige &amp; golden orange\r\nBahan: Leather premium\r\nSol: Rubber outsole anti-slip\r\nKesan: Sporty classic &amp; streetwear\r\n\r\nCocok untuk: Daily wear, hangout, street style, casual sporty look', 'tersedia'),
(27, 10, 'SOLIDO URBAN SLING BAG', 1200000, 'V4kSzGZDtFTMnKx9fx2Q.jpg', 'Tas sling dengan desain modern dan minimalis yang cocok untuk menunjang aktivitas harian. Terbuat dari bahan kulit sintetis premium bertekstur yang terlihat elegan sekaligus tahan lama. Warna navy memberikan kesan rapi, profesional, dan mudah dipadukan dengan berbagai outfit. Dilengkapi dengan kompartemen fungsional untuk menyimpan barang esensial dengan aman dan praktis.\r\n\r\nDetail Produk:\r\nModel: Sling bag / crossbody\r\nWarna: Navy blue\r\nBahan: Kulit sintetis premium\r\nPenutup: Resleting kokoh\r\nKesan: Modern, clean &amp; versatile\r\n\r\nCocok untuk: Daily wear, kerja santai, traveling, aktivitas kasual hingga semi-formal', 'tersedia'),
(28, 11, 'LUNA CHIC SHOULDER BAG', 2500000, 'kyb4Jsst4z3w6ATe8g4E.jpg', 'Tas wanita dengan desain elegan dan feminin yang cocok untuk menunjang penampilan modern. Menggunakan material premium bertekstur halus yang memberikan kesan mewah namun tetap ringan dan nyaman digunakan. Desain simpel dengan siluet rapi membuat tas ini mudah dipadukan dengan berbagai outfit, dari kasual hingga semi-formal. Tali yang adjustable menambah fleksibilitas pemakaian sesuai kebutuhan.\r\n\r\nDetail Produk:\r\nModel: Shoulder bag / sling bag wanita\r\nWarna: Hitam elegan\r\nBahan: Kulit sintetis premium\r\nPenutup: Resleting aman\r\nKesan: Feminine, chic &amp; modern\r\n\r\nCocok untuk: Daily wear, hangout, kerja, acara semi-formal, dan aktivitas harian wanita stylish', 'tersedia'),
(29, 5, 'NEW BALANCE CAP', 345000, 'nCWOvzeKhjLFr07LZ63s.jpeg', 'Topi stylish yang dirancang untuk melengkapi penampilan sehari-hari. Terbuat dari bahan berkualitas yang nyaman dipakai, ringan, dan tidak mudah panas. Cocok digunakan untuk aktivitas outdoor maupun casual, memberikan kesan simpel namun tetap trendi.', 'tersedia'),
(30, 5, 'TEDDY CAP', 179999, 'dvi9fYweFiwCGpVw8W5S.jpeg', 'Topi stylish yang dirancang untuk melengkapi penampilan sehari-hari. Terbuat dari bahan berkualitas yang nyaman dipakai, ringan, dan tidak mudah panas. Cocok digunakan untuk aktivitas outdoor maupun casual, memberikan kesan simpel namun tetap trendi.', 'tersedia'),
(32, 11, 'HANDBAG WOMEN\'S', 12000000, '1ZfGikj7xgEiinkgVgRN.jpeg', 'Handbag wanita berwarna hitam dengan desain elegan yang tidak lekang oleh waktu. Terbuat dari material berkualitas tinggi yang halus dan tahan lama. Tas ini memiliki ruang yang cukup untuk menyimpan kebutuhan harian seperti dompet, ponsel, dan kosmetik. Cocok dipadukan dengan outfit formal maupun casual untuk tampil lebih chic dan percaya diri.', 'tersedia'),
(33, 11, 'SLING BAG WOMEN\'S', 17000000, 'wgp2rqBx0FfdtIYSPosV.jpeg', 'Sling bag putih dengan desain minimalis yang cocok untuk menunjang aktivitas sehari-hari. Dibuat dari bahan berkualitas yang kuat dan tahan lama. Ukurannya pas untuk membawa barang penting seperti ponsel, dompet, dan aksesoris kecil. Mudah dipadukan dengan berbagai outfit kasual.', 'tersedia'),
(34, 10, 'SHOULDER BAG MAN', 124000000, 'PCc0RAQyaEWkhTVTYpn3.jpeg', 'Shoulder bag pria dengan desain simpel dan maskulin, cocok untuk menunjang aktivitas sehari-hari. Terbuat dari bahan berkualitas yang kuat dan tahan lama. Praktis untuk membawa barang penting seperti ponsel, dompet, dan kunci dengan tetap tampil rapi dan modern.', 'tersedia'),
(35, 10, 'MEN\'S BACKPACK', 355000000, 'EjQnHBuH6kpp3sgFbmQP.jpeg', 'Ransel pria dengan desain modern dan maskulin, cocok untuk menunjang aktivitas sehari-hari. Terbuat dari bahan berkualitas yang kuat dan tahan lama. Memiliki ruang penyimpanan yang luas dan beberapa kompartemen untuk menjaga barang tetap rapi. Nyaman digunakan untuk bekerja, kuliah, traveling, maupun aktivitas santai.', 'tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaksi`
--

CREATE TABLE `tbl_transaksi` (
  `id_transaksi` int(50) NOT NULL,
  `id_customer` int(50) NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `status_transaksi` varchar(50) NOT NULL,
  `total_produk` int(11) NOT NULL,
  `total_harga` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_transaksi`
--

INSERT INTO `tbl_transaksi` (`id_transaksi`, `id_customer`, `tanggal_transaksi`, `status_transaksi`, `total_produk`, `total_harga`) VALUES
(33, 28, '2026-01-02', 'Selesai', 17, 123501000),
(34, 29, '2026-01-04', 'Pending', 2, 3500999),
(35, 34, '2026-01-05', 'Pending', 1, 124001000),
(36, 35, '2026-01-05', 'Pending', 4, 720996),
(38, 38, '2026-04-28', 'Pending', 1, 1881000),
(39, 39, '2026-05-07', 'Proses', 1, 2251000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`) VALUES
('U001', 'Admin', 'Admin\r\n'),
('U002', 'putri', 'putri'),
('U003', 'mahesa', 'mahesa'),
('U004', 'cindi', 'cindi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indexes for table `tbl_detail_transaksi`
--
ALTER TABLE `tbl_detail_transaksi`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `fk_detail_ke_transaksi` (`id_transaksi`),
  ADD KEY `fk_detail_ke_produk` (`id_produk`);

--
-- Indexes for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nama` (`nama`),
  ADD KEY `kategori_produk` (`id_kategori`);

--
-- Indexes for table `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_customer` (`id_customer`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `id_customer` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tbl_detail_transaksi`
--
ALTER TABLE `tbl_detail_transaksi`
  MODIFY `id_detail` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tbl_transaksi`
--
ALTER TABLE `tbl_transaksi`
  MODIFY `id_transaksi` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_detail_transaksi`
--
ALTER TABLE `tbl_detail_transaksi`
  ADD CONSTRAINT `fk_detail_ke_produk` FOREIGN KEY (`id_produk`) REFERENCES `tbl_produk` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detail_ke_transaksi` FOREIGN KEY (`id_transaksi`) REFERENCES `tbl_transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  ADD CONSTRAINT `kategori_produk` FOREIGN KEY (`id_kategori`) REFERENCES `tbl_kategori` (`id_kategori`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
