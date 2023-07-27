CREATE TABLE board(
 num int not null auto_increment,
 id char(15) NOT null,
 name char (10)NOT null,
 subject char(200) Not null,
 content text NOT null,
 regist_day char(20) NOT null,
 hit int NOT null,
 file_name char(40),
 file_type char(40),
 file_copied char(40),
 primary key(num)
); 


CREATE TABLE members (
 num int NOT null auto_increment,
 id char(15) NOT null,
 pass char(15) NOT null,
 name char(10) NOT null,
 email char(80),
address varchar(30) not null,
 regist_day char(20),
 level int,
 point int,
 primary key(num)
  );


CREATE TABLE message(  
  num int NOT null auto_increment, 
  send_id char(20), 
  rv_id char(20) NOT null, 
  subject char(200) NOT null, 
  content text NOT null, 
  regist_day char(20), 
  primary key(num) 
  );


CREATE TABLE point_mall (
  num int not null auto_increment,
  product_name char(200)  not null,
  point int(11)   not null,
  file_name char(40)  not null,
  file_type char(40)  not null,
  file_copied char(40)  not null,
  primary key (num)
); 


INSERT INTO `point_mall` (`num`, `product_name`, `point`, `file_name`, `file_type`, `file_copied`) VALUES
(1, '롯데지류상품권 10만원권', 105000, '롯데.PNG', 'image/png', '2020_11_21_09_38_13.PNG'),
(2, '신세계모바일상품권 1만원권', 10500, '신세계 1만원.PNG', 'image/png', '2020_11_21_09_43_07.PNG'),
(3, '신세계모바일상품권 3만원권', 31500, '신세계 3만원.PNG', 'image/png', '2020_11_21_09_43_45.PNG'),
(4, '신세계모바일상품권 5만원권', 52500, '원신세계 5만.PNG', 'image/png', '2020_11_21_09_44_07.PNG'),
(5, '신세계모바일상품권 10만원권', 105000, '신세계 10만원.PNG', 'image/png', '2020_11_21_09_44_35.PNG'),
(6, '신세계모바일상품권 50만원권', 525000, '신세계 50만원.PNG', 'image/png', '2020_11_21_09_44_57.PNG'),
(7, '롯데마트 모바일 금액원 10000원', 10300, '롯데 10000.PNG', 'image/png', '2020_11_21_09_48_09.PNG'),
(8, '롯데마트 모바일 금액원 20000원', 20600, '롯데 20000.PNG', 'image/png', '2020_11_21_09_48_23.PNG'),
(9, '롯데마트 모바일 금액원 30000원', 30900, '롯데 30000.PNG', 'image/png', '2020_11_21_09_48_39.PNG'),
(10, '롯데마트 모바일 금액원 50000원', 51500, '롯데 50000.PNG', 'image/png', '2020_11_21_09_49_06.PNG'),
(11, '롯데마트 모바일 금액원 500000원', 515000, '롯데 500000.PNG', 'image/png', '2020_11_21_09_49_27.PNG'),
(12, 'S-OIL상품권 10000원', 10500, 'sol 10000.PNG', 'image/png', '2020_11_21_09_51_27.PNG'),
(13, 'S-OIL상품권 20000원', 21000, 'sol 20000.PNG', 'image/png', '2020_11_21_09_51_41.PNG'),
(14, 'S-OIL상품권 30000원', 31500, 'sol 30000.PNG', 'image/png', '2020_11_21_09_51_56.PNG'),
(15, 'S-OIL상품권 50000원', 52500, 'sol 50000.PNG', 'image/png', '2020_11_21_09_52_13.PNG'),
(16, 'CJ기프트카드 1만원권', 10000, 'cj 10000.PNG', 'image/png', '2020_11_21_09_59_25.PNG'),
(17, 'CJ기프트카드 2만원권', 20000, 'cj 20000.PNG', 'image/png', '2020_11_21_09_59_44.PNG'),
(18, 'CJ기프트카드 3만원권', 30000, 'cj 30000.PNG', 'image/png', '2020_11_21_09_59_59.PNG');


CREATE TABLE point_mall_buy (
  num int not null auto_increment,
  product_name char(255) not null,
  pin_number char(25) not null,
  id char(15) not null,
  order_check char(20) not null,
  PRIMARY KEY (num)
) ;