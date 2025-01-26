-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2025 at 04:03 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `digitalstay`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `admin_username` varchar(255) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin_username`, `password`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `subject`, `message`) VALUES
(1, 'Bibek Kaliraj ', 'bibek@gmail.com', 'approval', 'Hi, I would like to look after my reservation approval.'),
(2, 'Dibisha Joshi', 'db@gmail.com', 'demo', 'testing12234567890');

-- --------------------------------------------------------

--
-- Table structure for table `hotel`
--

CREATE TABLE `hotel` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `L_id` int(10) UNSIGNED DEFAULT NULL,
  `active_status` enum('active','inactive') DEFAULT 'inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotel`
--

INSERT INTO `hotel` (`id`, `name`, `address`, `image`, `description`, `L_id`, `active_status`) VALUES
(1, 'Annapurna Hotel', 'Durbarmarg', 'uploads/hotels/hotelannapurna.jpg', 'Located in the heart of the city, Hotel Annapurna, Kathmandu is the first 5-star hotel to be established in the country in 1965. Named after the Goddess Annapurna, the Goddess of plenty, this 5.5-acre haven offers both comfort and convenience, making it the ultimate address for both leisure and business travelers.', 1, 'active'),
(2, 'Raddison Hotel', 'Lazimpat', 'uploads/hotels/raddisonhotel.jpg', 'Radisson Hotel Kathmandu is a city center hotel, perfect for business and leisure travelers alike with easy access to the commercial hub of Kathmandu and popular attractions like Thamel, Narayanhiti Palace Museum, and historical Kathmandu Durbar Square.\r\n\r\nEach of our air-conditioned rooms features a comfortable and spacious area equipped with a flat-screen TV, free Wi-Fi, coffee and tea facilities, complimentary toiletries, minibar, and a dedicated workspace. Enjoy a variety of cuisines at our on-site restaurants, pamper yourself at our spa, or stay active at our fitness center and swimming pool. We also have a business center and offer concierge services, travel and tour facilities, meeting and banquet spaces, and laundry services.', 1, 'active'),
(3, 'The Everest Hotel', 'Madan Bhandari Road New Baneshwor, Kathmandu 44600 Nepal]', 'uploads/hotels/TheEverestHotel.jpg', 'The Everest Hotel, one of the most premium 5 star hotels in Nepal, is located just 3 Kms from Kathmandu International Airport and International Convention Centre and conveniently established at a place surrounded by Tourist hotspots, shopping Centre, key corporate offices, banks, Pashupatinath temple and Changu Narayan Temple. The hotel boasts of recently renovated 160 Deluxe,Club rooms and Suites, 15000 Sq. Ft of banqueting, an all day dining Multi-Cuisine restaurant, State of the art Bar, outdoor swimming pool, 24/7 Health Club & Spa and offer all modern amenities such as spacious wardrobe, an LCD television, mini bar, complimentary high speed internet.', 1, 'active'),
(4, 'Hyatt Place', 'Soalteemode, Kathmandu', 'uploads/hotels/hyatt place.jpg', 'Situated in Kathmandu, 2.4 km from Kathmandu Durbar Square, Hyatt Place Kathmandu features accommodation with an outdoor swimming pool, free private parking, a fitness centre and a shared lounge. Among the facilities of this property are a restaurant, room service and a 24-hour front desk, along with free WiFi throughout the property. The accommodation provides an ATM, a concierge service and luggage storage for guests.', 1, 'active'),
(5, 'Hotel Bhadgaon', 'Barahisthan-4, Bhaktapur', 'uploads/hotels/hotel bhadgaon.jpg', 'Bhadgaon Hotel in its own name preserves the historic value as the city of Bhaktapur was previously called Bhadgaon hundreds of years ago. The name evolved but our aspiration towards the guests and heritage has remained constant. Hotel Bhadgaon promotes the local style of residence and mimics the cultural values in its own building. The decors and designs all in their own way, shape and form are part of the tradition of Bhadgaon and we pride to the utmost standard in having privilege to do so.', 2, 'active'),
(6, 'Tulaja Boutique Hotel', 'Balakhu 2, Bhaktapur 44800 Nepal', 'uploads/hotels/TulajaBoutiqueHotel.jpg', 'Hotel Tulaja Boutique Home is a newly established six-story property situated at Bhaktapur, simply a minute carefree walk from the heart of the Bhaktapur Durbar Square. Away from the sights and sounds of the densely populated city Kathmandu, the home has crystal white, light blue and pink color in its outer and inner texture. It offers an allowance of a gorgeous panoramic views of the Kathmandu Valley including the enticing sight of the different mountain ranges from its rooftop restaurant.', 2, 'active'),
(7, 'Hotel Portland', '  Lakeside Road, 33700 Pokhara', 'uploads/hotels/HotelPortland.jpg', 'Hotel Portland is majestically located near lake side, offering guaranted magical view of Fewa lake. Great location, stylish building and aesthetic decor are key reasons for the guests for repeated stay and high referrals. Unmatched service quality cannot be missed by experience here. Welcome to Pokhara, be our guest.', 3, 'active'),
(8, 'Majestic Lake Front Hotel & Suites', 'Baidam Road, 33700 Pokhara, Nepal', 'uploads/hotels/Magestic Hotel.jpg', 'Majestic Lake Front Hotel and Suites offers 3-star accommodation with an array of amenities for a comfortable stay. Guests can enjoy an outdoor swimming pool, free private parking, a garden, and a shared lounge. The hotel features air-conditioned rooms with complimentary Wi-Fi, each equipped with a private bathroom. For guest convenience, Majestic Lake Front Hotel and Suites offers room service, a 24-hour front desk, and In house restaurant. All rooms are furnished with a kettle, and some units offer scenic lake views with balconies. Each guest room is also equipped with a flat-screen TV and complimentary toiletries. Guests can start their day with a continental breakfast and dine at the Grounds by Majestic, which serves a variety of cuisine including American, Chinese, and British dishes. Vegetarian, halal, and kosher options are available upon request.', 3, 'active'),
(9, 'Hotel Om\'s Home', 'Marpha 33100 Nepal', 'uploads/hotels/hotel oms home.jpg', 'Located in the capital of picturesque Mustang district under the mighty Nilgiri Himal, Omâ€™s Home has a rich historic legacy. Built in 1976, this beautiful heritage hotel is constructed in the traditional style, the soul of Mustang reflected in every element of the architecture.', 4, 'inactive');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `active_status` tinyint(1) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `name`, `active_status`, `image`) VALUES
(1, 'Kathmandu', 1, 'uploads/kathmandu.jpg'),
(2, 'Bhaktapur', 1, 'uploads/Bhaktapur.jpg'),
(3, 'Pokhara', 1, 'uploads/pokhara.jpg'),
(4, 'Mustang', 1, 'uploads/mustang.jpg'),
(5, 'Illam', 1, 'uploads/illam.jpg'),
(6, 'Lumbini', 1, 'uploads/lumbini.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` varchar(255) NOT NULL,
  `Reservation_id` int(10) UNSIGNED DEFAULT NULL,
  `Amount` int(11) DEFAULT NULL,
  `Status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `Reservation_id`, `Amount`, `Status`) VALUES
('Payment_6768b79b4e1fd', 53, 4900, 'paid'),
('Payment_6768da0aaff7e', 54, 6000, 'paid');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(10) UNSIGNED NOT NULL,
  `check_in` date DEFAULT NULL,
  `check_out` date DEFAULT NULL,
  `u_id` int(10) UNSIGNED DEFAULT NULL,
  `hotel_id` int(10) UNSIGNED NOT NULL,
  `status_id` int(10) UNSIGNED NOT NULL,
  `available_rooms` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`id`, `check_in`, `check_out`, `u_id`, `hotel_id`, `status_id`, `available_rooms`) VALUES
(53, '2024-12-23', '2024-12-24', 1, 7, 1, 0),
(54, '2024-12-24', '2024-12-25', 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `reservation_room`
--

CREATE TABLE `reservation_room` (
  `r_id` int(10) UNSIGNED DEFAULT NULL,
  `adult_no` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `reservation_id` int(10) UNSIGNED DEFAULT NULL,
  `num_rooms` int(11) DEFAULT 1,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation_room`
--

INSERT INTO `reservation_room` (`r_id`, `adult_no`, `price`, `reservation_id`, `num_rooms`, `id`) VALUES
(14, 1, 4900, 53, 1, 42),
(1, 1, 6000, 54, 1, 43);

-- --------------------------------------------------------

--
-- Table structure for table `reservation_status`
--

CREATE TABLE `reservation_status` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `badge_class` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation_status`
--

INSERT INTO `reservation_status` (`id`, `name`, `badge_class`) VALUES
(1, 'Pending', 'pending'),
(2, 'Checked In', 'checkedin'),
(3, 'Checked Out', 'checkedout'),
(4, 'Cancelled', 'cancelled');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `adult_no` int(11) DEFAULT NULL,
  `hotel_id` int(10) UNSIGNED DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `name`, `price`, `description`, `adult_no`, `hotel_id`, `image`, `quantity`) VALUES
(1, 'Suite', 6000, 'Depending on the equipment of the hotel, the suite rooms have air conditioning, TV, refrigerator, iron and different furniture options. The more facilities offered by the suite rooms cause a price difference between them and the standard rooms. Suite rooms are not just places to sleep or relax during the day.', 2, 1, 'suiteroom.jpg', 5),
(2, 'Duplex', 6000, 'Duplex room, the duplex suite comprises two rooms situated different floors which are connected by an internal staircase.', 2, 2, 'duplex.jpg', 2),
(3, 'HERITAGE DOUBLE OR TWIN ROOM -', 8000, 'This air-conditioned room features heating facilities and a seating area and is equipped with a safe, flat-screen TV, tea and coffee making facilities, telephone and minibar. The attached bathroom has shower facilities.', 2, 1, 'hotelannapurna-HERITAGE DOUBLE OR TWIN ROOM.jpg', 3),
(4, 'TRIPLE ROOM', 5000, 'Room with double with an extra bed or three separate beds room with flat screen Samsung TV with satellite channels.\nRooms are equipped with coffee/tea facilities, and a minibar.', 3, 1, 'hotelannapurna-TRIPLE ROOM.jpg', 4),
(5, 'Premium Room', 9000, 'Perfect for business travelers or couples on a romantic retreat, our Premium Rooms offer premium comfort and convenience. Choose your preference of king or twin bed. Once you settle in, relax in the m', 3, 2, 'Radisson-Superior room.png', 3),
(6, 'Junior Suite Room', 8000, 'Our Junior Suite is all about open spaces, offering studio-style accommodation with sweeping views of the valley. Individual climate control and plush bedding ensure a comfortable night’s sleep, and c', 3, 2, 'Raddisson-Junior Suite Room.png', 5),
(7, 'Suite Room', 11000, 'Spacious room features a safe, hairdryer and ironing facilities. Offers Club benefits including free breakfast, express check in/out, lounge access and free return airport transfers provided.', 2, 3, 'TheEverestHotel-Suite.jpg', 6),
(8, 'Club Twin Room', 12000, 'Offering free toiletries and bathrobes, this twin room includes a private bathroom with a bath, a shower and a bidet. The air-conditioned twin room offers a flat-screen TV with cable channels, a priva', 2, 3, 'TheEverestHotel-ClubTwin.jpg', 6),
(9, 'Deluxe Twin Room', 13000, 'Offering free toiletries and bathrobes, this twin room includes a private bathroom with a bath, a shower and a bidet. The air-conditioned twin room offers a flat-screen TV with cable channels, a priva', 2, 3, 'TheEverestHotel-DeluxeTwin.jpg', 7),
(10, 'Deluxe Room', 15000, '1 extra-large double bed \r\nFeatures free access to swimming pool, fitness center and sauna.', 2, 3, 'TheEverestHotel-Deluxe.jpg', 7),
(11, 'King Room', 15000, 'Providing free toiletries and bathrobes, this triple room includes a private bathroom with a walk-in shower, a hairdryer and slippers. The air-conditioned triple room provides a flat-screen TV with st', 2, 4, 'Hyatt-kingroom.jpg', 5),
(12, 'Twin Room', 13000, 'Offering free toiletries and bathrobes, this triple room includes a private bathroom with a walk-in shower, a hairdryer and slippers. The air-conditioned triple room offers a flat-screen TV with strea', 2, 4, 'Hyatt-twinroom.jpg', 5),
(13, 'King-Suite Room', 20000, 'Featuring free toiletries and bathrobes, this suite includes a private bathroom with a walk-in shower, a hairdryer and slippers. The spacious air-conditioned suite features a flat-screen TV with strea', 2, 4, 'Hyatt-kingsuite.jpg', 5),
(14, 'Deluxe Double Room', 4900, 'This air-conditioned room features heating facilities and a seating area and is equipped with a safe, flat-screen TV, tea and coffee making facilities, telephone and minibar.', 2, 7, 'HotelPortland-deluxedoubleroom.jpg', 6),
(15, 'Deluxe Double or Twin Room', 5000, 'This air-conditioned twin/double room includes a flat-screen TV with cable channels, a private bathroom as well as a balcony with garden views.', 2, 5, 'hotelbhadgaon-deluxe double.jpg', 4),
(16, 'Deluxe Twin Room', 8000, 'Deluxe rooms come fully furnished with study tables, comfortable and healthy meeting chairs and tables, wide spread bed with special comfort mattress and tidy sheets. We will arrange your rooms with sleeping arrangements as required with twin beds, or single king or queen size bed as required by the demand and necessity of the customer.', 1, 5, 'hotelbhadgaon-deluxeroom.jpg', 4),
(17, 'Double Deluxe Room', 9000, 'The rooms feature clothes rack. Private bathroom also comes with free toiletries. Extras include bed linen, ironing facilities and a fan.', 1, 6, 'hotelbhadgaon-deluxeroom.jpg', 4),
(18, 'Standard Twin Room', 6000, 'Offering free toiletries, this twin room includes a private bathroom with a shower, a hairdryer and slippers. A wardrobe, an electric kettle and parquet floors are offered in this twin room. The unit has 2 beds.', 2, 6, 'tulajaboutique standard twin room.jpg', 4),
(19, 'Double Suite Room', 6000, 'The rooms feature clothes rack. Private bathroom also comes with free toiletries. Extras include bed linen, ironing facilities and a fan.', 2, 6, 'tulajaboutique deluxe double room.jpg', 5),
(20, 'Deluxe Twin Room', 7000, 'The fireplace is a top feature of this twin room. This air-conditioned twin room has a private bathroom, soundproof walls, a wardrobe as well as a terrace. The unit has 2 beds.', 2, 7, 'hotelportland deluxe twin room.jpg', 5),
(21, 'Superior Double Room', 7000, 'The air-conditioned double room provides a flat-screen TV with cable channels, a minibar, a tea and coffee maker, heating as well as garden views. The unit offers 1 bed.', 2, 8, 'Majestic Superior Double Room.jpg', 4),
(22, 'Family Room', 7000, 'The air-conditioned double room provides a flat-screen TV with cable channels, a minibar, a tea and coffee maker, heating as well as garden views. The unit offers 2 bed.', 4, 8, 'Magestic Family room.jpg', 4),
(23, 'Deluxe Twin room', 9000, 'With free WiFi, this room includes seating area and a sofa. Room Facilities: Shower, Sitting area, Electric Kettle, Toilet, Private, bathroom ,heater, sofa.', 2, 9, 'om deluxe twin room.jpg', 4),
(24, 'Suite Room', 6000, 'This spacious room offers a view of the Nilgiri Mountains. It includes a seating area with free Wi-Fi.\r\n', 2, 9, 'om suite room.jpg', 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(15) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `contact_number` varchar(10) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `contact_number`, `full_name`) VALUES
(1, 'dibisha_joshi', '6d6d5f54881d9b8304bf47c0127baeb2', 'joshidbsa123@gmail.com', '9860640413', 'Dibisha Joshi'),
(2, 'bibekkaliraj', 'bb8fbd58a0c71e736a20cebf8e4dbfcd', 'bibek@gmail.com', '9812345678', 'Bibek Kaliraj'),
(6, 'sanita', '6d6d5f54881d9b8304bf47c0127baeb2', 'sanita@gmail.com', '9876543212', 'Sanita Maharjan'),
(18, 'sahilcha', '5549ab53c3da53024087f9971ead367d', 'shakyasahil@gmail.com', '9860789569', 'Sahil Shakya'),
(19, 'prastu_', '8744c2f8c863c05ad33f5dd63e242613', 'prastabana419@gmail.com', '9869256853', 'Prastabana Shrestha'),
(20, 'srsty', '75101dcdfc88455bcafc9e53e0b06689', 'shristidwdi@gmail.com', '9818496156', 'Shristi Dawadi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotel`
--
ALTER TABLE `hotel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `L_id` (`L_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `Reservation_id` (`Reservation_id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `u_id` (`u_id`),
  ADD KEY `fk_hotel` (`hotel_id`);

--
-- Indexes for table `reservation_room`
--
ALTER TABLE `reservation_room`
  ADD PRIMARY KEY (`id`),
  ADD KEY `r_id` (`r_id`),
  ADD KEY `reservation_id` (`reservation_id`);

--
-- Indexes for table `reservation_status`
--
ALTER TABLE `reservation_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hotel`
--
ALTER TABLE `hotel`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `reservation_room`
--
ALTER TABLE `reservation_room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `reservation_status`
--
ALTER TABLE `reservation_status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hotel`
--
ALTER TABLE `hotel`
  ADD CONSTRAINT `hotel_ibfk_1` FOREIGN KEY (`L_id`) REFERENCES `location` (`id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`Reservation_id`) REFERENCES `reservation` (`id`);

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `fk_hotel` FOREIGN KEY (`hotel_id`) REFERENCES `hotel` (`id`),
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `reservation_room`
--
ALTER TABLE `reservation_room`
  ADD CONSTRAINT `reservation_room_ibfk_1` FOREIGN KEY (`r_id`) REFERENCES `room` (`id`),
  ADD CONSTRAINT `reservation_room_ibfk_2` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`id`);

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `hotel` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
