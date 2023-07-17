-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 18 May 2020, 02:09:40
-- Sunucu sürümü: 10.4.11-MariaDB
-- PHP Sürümü: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `restoran`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `garson`
--

CREATE TABLE `garson` (
  `id` int(11) NOT NULL,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `sifre` varchar(40) COLLATE utf8_turkish_ci NOT NULL,
  `durum` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `garson`
--

INSERT INTO `garson` (`id`, `ad`, `sifre`, `durum`) VALUES
(1, 'talha', '14', 0),
(2, 'kerem', '12', 1),
(3, 'berkay', '13', 0),
(4, 'tkb', '11', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gecicigarson`
--

CREATE TABLE `gecicigarson` (
  `id` int(11) NOT NULL,
  `garsonid` int(11) NOT NULL,
  `garsonad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `adet` int(11) NOT NULL,
  `hasilat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `gecicigarson`
--

INSERT INTO `gecicigarson` (`id`, `garsonid`, `garsonad`, `adet`, `hasilat`) VALUES
(1, 2, 'kerem', 26, 226);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gecicimasa`
--

CREATE TABLE `gecicimasa` (
  `id` int(11) NOT NULL,
  `masaid` int(11) NOT NULL,
  `masaad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `hasilat` float NOT NULL,
  `adet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `gecicimasa`
--

INSERT INTO `gecicimasa` (`id`, `masaid`, `masaad`, `hasilat`, `adet`) VALUES
(1, 3, 'MASA-3', 9, 3),
(2, 2, 'MASA-2', 70, 4),
(3, 6, 'MASA-6', 14, 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gecicimusteri`
--

CREATE TABLE `gecicimusteri` (
  `id` int(11) NOT NULL,
  `musteriid` int(11) NOT NULL,
  `masaad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `adsoyad` varchar(40) COLLATE utf8_turkish_ci NOT NULL,
  `telefon` varchar(11) COLLATE utf8_turkish_ci NOT NULL,
  `email` varchar(40) COLLATE utf8_turkish_ci NOT NULL,
  `hasilat` int(11) NOT NULL,
  `adet` int(11) NOT NULL,
  `odeme` varchar(10) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `gecicimusteri`
--

INSERT INTO `gecicimusteri` (`id`, `musteriid`, `masaad`, `adsoyad`, `telefon`, `email`, `hasilat`, `adet`, `odeme`) VALUES
(1, 16, 'MASA-6', 'mahmut tuncer', '5396253956', 'mahmuttuncer@gmail.com', 9, 3, 'NAKİT'),
(2, 15, 'MASA-5', 'kuçukkuyulu dalha', '12345678900', 'kucukdalha@gucukkuyu.com', 20, 2, 'NAKİT'),
(3, 13, 'MASA-11', 'kerem kaçak', '5074973397', 'keremkacak2000@gmail.com', 10, 2, 'NAKİT'),
(4, 17, 'MASA-5', 'ibrahim tatlıses', '5326987596', 'ibotatlı@gmail.com', 40, 2, 'KREDİ'),
(5, 14, 'MASA-1', 'berkay kuru', '5380219916', 'berkaykuru18@outlook.com', 14, 2, 'NAKİT');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `geciciurun`
--

CREATE TABLE `geciciurun` (
  `id` int(11) NOT NULL,
  `urunid` int(11) NOT NULL,
  `urunad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `hasilat` float NOT NULL,
  `adet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `geciciurun`
--

INSERT INTO `geciciurun` (`id`, `urunid`, `urunad`, `hasilat`, `adet`) VALUES
(1, 9, 'Gazoz', 9, 3),
(2, 11, 'Pastırmalı fasulye', 30, 2),
(3, 5, 'Adana', 40, 2),
(4, 6, 'Mercimek', 14, 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kasiyer`
--

CREATE TABLE `kasiyer` (
  `id` int(11) NOT NULL,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `sifre` varchar(40) COLLATE utf8_turkish_ci NOT NULL,
  `durum` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `kasiyer`
--

INSERT INTO `kasiyer` (`id`, `ad`, `sifre`, `durum`) VALUES
(1, 'talha', '1', 0),
(2, 'kerem', '2', 1),
(3, 'berkay', '3', 0),
(4, 'tkb', '4', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategoriler`
--

CREATE TABLE `kategoriler` (
  `id` int(11) NOT NULL,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `mutfakdurum` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `kategoriler`
--

INSERT INTO `kategoriler` (`id`, `ad`, `mutfakdurum`) VALUES
(1, 'Sıcak İçeçekler', 0),
(2, 'Soğuk İçeçekler', 0),
(3, 'Tatlılar', 0),
(4, 'Ana Yemek', 0),
(5, 'Kebaplar', 0),
(6, 'Çorbalar', 0),
(7, 'Salatalar', 0),
(8, 'Pizzalar', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `masalar`
--

CREATE TABLE `masalar` (
  `id` int(11) NOT NULL,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `masalar`
--

INSERT INTO `masalar` (`id`, `ad`) VALUES
(1, 'MASA-1'),
(2, 'MASA-2'),
(3, 'MASA-3'),
(4, 'MASA-4'),
(5, 'MASA-5'),
(6, 'MASA-6'),
(7, 'MASA-7'),
(8, 'MASA-8'),
(9, 'MASA-9'),
(10, 'MASA-10'),
(11, 'MASA-11'),
(12, 'MASA-12');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `musteri`
--

CREATE TABLE `musteri` (
  `id` int(11) NOT NULL,
  `adsoyad` varchar(40) COLLATE utf8mb4_turkish_ci NOT NULL,
  `telefon` varchar(11) COLLATE utf8mb4_turkish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `musteri`
--

INSERT INTO `musteri` (`id`, `adsoyad`, `telefon`, `email`) VALUES
(13, 'kerem kaçak', '05074973397', 'keremkacak2000@gmail.com'),
(14, 'berkay kuru', '05380219916', 'berkaykuru18@outlook.com'),
(15, 'kuçukkuyulu dalha', '12345678900', 'kucukdalha@gucukkuyu.com'),
(16, 'mahmut tuncer', '05396253956', 'mahmuttuncer@gmail.com'),
(17, 'ibrahim tatlıses', '05326987596', 'ibotatlı@gmail.com'),
(19, 'osman aga', '05369575956', 'usman@gmail.com'),
(20, 'son olsun', '05236589654', 'son@gmail.com'),
(21, 'fwerf iafds', '02589631478', 'weffwr@fewfcdv'),
(22, 'tkb ikk', '12345678911', 'tkb@gmail.com');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `musterimasa`
--

CREATE TABLE `musterimasa` (
  `id` int(11) NOT NULL,
  `masaid` int(11) NOT NULL,
  `musteriid` int(11) NOT NULL,
  `adsoyad` varchar(40) COLLATE utf8_turkish_ci NOT NULL,
  `durum` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `mutfaksiparis`
--

CREATE TABLE `mutfaksiparis` (
  `id` int(11) NOT NULL,
  `masaid` int(11) NOT NULL,
  `urunid` int(11) NOT NULL,
  `urunad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `adet` int(11) NOT NULL,
  `saat` int(11) NOT NULL DEFAULT 0,
  `dakika` int(11) NOT NULL DEFAULT 0,
  `durum` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `mutfaksiparis`
--

INSERT INTO `mutfaksiparis` (`id`, `masaid`, `urunid`, `urunad`, `adet`, `saat`, `dakika`, `durum`) VALUES
(8, 6, 7, 'Mozeralla', 5, 1, 41, 0),
(12, 2, 28, 'Bira', 30, 0, 50, 1),
(13, 9, 19, 'Tavuklu Ham.', 11, 0, 50, 0),
(14, 9, 17, 'Ton Balıklı', 1, 0, 57, 1),
(22, 5, 45, 'Lüfer Izgara', 3, 20, 52, 0),
(23, 14, 53, 'Köfte Menü', 3, 22, 21, 0),
(24, 14, 3, 'Su', 1, 22, 21, 0),
(26, 18, 12, 'Kaşarlı Tost', 3, 22, 30, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `rapor`
--

CREATE TABLE `rapor` (
  `id` int(11) NOT NULL,
  `masaid` int(11) NOT NULL,
  `masaad` varchar(10) COLLATE utf8_turkish_ci NOT NULL,
  `garsonid` int(11) NOT NULL,
  `urunid` int(11) NOT NULL,
  `musteriid` int(11) NOT NULL,
  `musveri` varchar(40) COLLATE utf8_turkish_ci NOT NULL,
  `urunad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `urunfiyat` float NOT NULL,
  `adet` int(11) NOT NULL,
  `odeme` varchar(10) COLLATE utf8_turkish_ci NOT NULL,
  `tarih` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `rapor`
--

INSERT INTO `rapor` (`id`, `masaid`, `masaad`, `garsonid`, `urunid`, `musteriid`, `musveri`, `urunad`, `urunfiyat`, `adet`, `odeme`, `tarih`) VALUES
(143, 6, 'MASA-6', 2, 9, 16, 'mahmut tuncer', 'Gazoz', 3, 3, 'NAKİT', '2020-05-13'),
(144, 5, 'MASA-5', 2, 8, 15, 'kuçukkuyulu dalha', 'Sıcak çikolata', 10, 2, 'NAKİT', '2020-05-13'),
(145, 11, 'MASA-11', 2, 14, 13, 'kerem kaçak', 'Salep', 5, 2, 'NAKİT', '2020-05-13'),
(146, 5, 'MASA-5', 2, 5, 17, 'ibrahim tatlıses', 'Adana', 20, 2, 'KREDİ', '2020-05-13'),
(147, 1, 'MASA-1', 2, 7, 14, 'berkay kuru', 'Kahve', 7, 2, 'NAKİT', '2020-05-14'),
(148, 2, 'MASA-2', 2, 2, 22, 'tkb ikk', 'Kola', 2, 2, 'NAKİT', '2020-05-14'),
(149, 3, 'MASA-3', 2, 11, 22, 'tkb ikk', 'Pastırmalı fasulye', 15, 2, 'KREDİ', '2020-05-14'),
(152, 6, 'MASA-6', 2, 9, 16, 'mahmut tuncer', 'Gazoz', 3, 2, 'KREDİ', '2020-05-14'),
(155, 3, 'MASA-3', 2, 9, 13, 'kerem kaçak', 'Gazoz', 3, 3, 'KREDİ', '2020-05-17'),
(157, 2, 'MASA-2', 2, 11, 14, 'berkay kuru', 'Pastırmalı fasulye', 15, 2, 'NAKİT', '2020-05-17'),
(158, 2, 'MASA-2', 2, 5, 17, 'ibrahim tatlıses', 'Adana', 20, 2, 'NAKİT', '2020-05-17'),
(159, 6, 'MASA-6', 2, 6, 19, 'osman aga', 'Mercimek', 7, 2, 'NAKİT', '2020-05-17');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparis`
--

CREATE TABLE `siparis` (
  `id` int(11) NOT NULL,
  `masaid` int(11) NOT NULL,
  `garsonid` int(11) NOT NULL,
  `urunid` int(11) NOT NULL,
  `musteriid` int(11) NOT NULL,
  `urunad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `urunfiyat` float NOT NULL,
  `adet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urunler`
--

CREATE TABLE `urunler` (
  `id` int(11) NOT NULL,
  `katid` int(11) NOT NULL,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `fiyat` float NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `urunler`
--

INSERT INTO `urunler` (`id`, `katid`, `ad`, `fiyat`, `stok`) VALUES
(1, 1, 'Çay', 5, -2),
(2, 2, 'Kola', 2, 0),
(3, 3, 'Künefe', 15, 0),
(4, 4, 'Patatesli tavuk', 15, 0),
(5, 5, 'Adana', 20, 0),
(6, 6, 'Mercimek', 7, 0),
(7, 1, 'Kahve', 7, 0),
(8, 1, 'Sıcak çikolata', 10, 0),
(9, 2, 'Gazoz', 3, 0),
(10, 3, 'Baklava', 30, 0),
(11, 4, 'Pastırmalı fasulye', 15, 0),
(12, 5, 'Urfa', 20, 0),
(13, 6, 'Domates çorbası', 7, 0),
(14, 1, 'Salep', 5, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yonetici`
--

CREATE TABLE `yonetici` (
  `id` int(11) NOT NULL,
  `kulad` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `sifre` varchar(50) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `yonetici`
--

INSERT INTO `yonetici` (`id`, `kulad`, `sifre`) VALUES
(1, 'tkb', 'f61532c34f711a6fab5bbee86bdbadc1');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `garson`
--
ALTER TABLE `garson`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `gecicigarson`
--
ALTER TABLE `gecicigarson`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `gecicimasa`
--
ALTER TABLE `gecicimasa`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `gecicimusteri`
--
ALTER TABLE `gecicimusteri`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `geciciurun`
--
ALTER TABLE `geciciurun`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kasiyer`
--
ALTER TABLE `kasiyer`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kategoriler`
--
ALTER TABLE `kategoriler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `masalar`
--
ALTER TABLE `masalar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `musteri`
--
ALTER TABLE `musteri`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `musterimasa`
--
ALTER TABLE `musterimasa`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `mutfaksiparis`
--
ALTER TABLE `mutfaksiparis`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `rapor`
--
ALTER TABLE `rapor`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `siparis`
--
ALTER TABLE `siparis`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `urunler`
--
ALTER TABLE `urunler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `yonetici`
--
ALTER TABLE `yonetici`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `garson`
--
ALTER TABLE `garson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `gecicigarson`
--
ALTER TABLE `gecicigarson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `gecicimasa`
--
ALTER TABLE `gecicimasa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `gecicimusteri`
--
ALTER TABLE `gecicimusteri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `geciciurun`
--
ALTER TABLE `geciciurun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `kasiyer`
--
ALTER TABLE `kasiyer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `kategoriler`
--
ALTER TABLE `kategoriler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `masalar`
--
ALTER TABLE `masalar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Tablo için AUTO_INCREMENT değeri `musteri`
--
ALTER TABLE `musteri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Tablo için AUTO_INCREMENT değeri `musterimasa`
--
ALTER TABLE `musterimasa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- Tablo için AUTO_INCREMENT değeri `mutfaksiparis`
--
ALTER TABLE `mutfaksiparis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Tablo için AUTO_INCREMENT değeri `rapor`
--
ALTER TABLE `rapor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- Tablo için AUTO_INCREMENT değeri `siparis`
--
ALTER TABLE `siparis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=432;

--
-- Tablo için AUTO_INCREMENT değeri `urunler`
--
ALTER TABLE `urunler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Tablo için AUTO_INCREMENT değeri `yonetici`
--
ALTER TABLE `yonetici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
