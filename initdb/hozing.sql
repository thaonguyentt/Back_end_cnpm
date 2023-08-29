DROP table if exists user;
CREATE TABLE user (
    id int(11) AUTO_INCREMENT PRIMARY KEY COMMENT 'Id nguoi dung',
    username varchar(255) COMMENT 'Ten dang nhap',
   	firstname varchar(255) COMMENT 'Ten',
    lastname varchar(255) COMMENT 'Ho',
    hashed_password varchar(255) COMMENT 'Mat khau hash',
    address varchar(255) COMMENT 'Dia chi',
    email varchar(100) COMMENT 'Email',
    phone_number varchar(15) COMMENT 'So dien thoai',
    is_admin tinyint(1) COMMENT 'La quan tri vien'
);

drop table if exists room;
CREATE TABLE room (
    room_code int(11) COMMENT 'Ma phong',
    num_people int(2) COMMENT 'so luong nguoi',
   	area decimal(10,2) COMMENT 'dien tich',
    price decimal(10,0)COMMENT 'tien phong',
    description varchar(10000) COMMENT 'mo ta',
    room_name varchar(50) COMMENT 'ten phong',
    link_image varchar(255) COMMENT 'duong dan hinh anh'
);

insert into room
values
(1001,2,65,110,'Phòng suite room là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'DOUBLE BED ROOM', 'https://i.ibb.co/QNkMLRk/2001.jpg'),
(1002,2,905,200,'Phòng Deluxe Ocean View là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'FAMILY ROOM', 'https://i.ibb.co/Qf5b746/1009.jpg'),
(1003,2,25,270,'Phòng suite room là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'CONNECTING ROOM', 'https://i.ibb.co/Pwv12QS/1008.jpg'),
(1004,2,25,200,'Phòng Deluxe Ocean View là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'SUITE ROOM', 'https://i.ibb.co/HqQzwFx/1007.jpg'),
(2001,2,65,110,'Phòng suite room là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'FAMILY ROOM', 'https://i.ibb.co/1T9pFLJ/1006.jpg'),
(2002,1,65,100,'Phòng Deluxe Ocean View là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'deluxe room', 'https://i.ibb.co/TwPTCdw/hozing-room-9-2.jpg'),
(2003,1,65,210,'Phòng suite room là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'DELUXE ROOM', 'https://i.ibb.co/xDNcJb0/hozing-room-9-1.jpg'),
(2004,3,65,200,'Phòng Deluxe Ocean View là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'deluxe room', 'https://i.ibb.co/QNkMLRk/2001.jpg'),
(3001,5,200,300,'Phòng suite room là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'DELUXE ROOM', 'https://i.ibb.co/pvNsxFr/hozing-room-8.jpg'),
(3002,3,65,110,'Phòng Deluxe Ocean View là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'deluxe room', 'https://i.ibb.co/h1nhds4/hozing-room-7.jpg'),
(3003,3,65,300,'Phòng suite room là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'CONNECTING ROOM','https://i.ibb.co/PTrYgBd/hozing-room-6-2.jpg'),
(3004,1,105,110,'Phòng Deluxe Ocean View là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'deluxe room', 'https://i.ibb.co/1nmB7Vz/hozing-room-6.jpg'),
(4001,3,35,200,'Phòng suite room là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'CONNECTING ROOM', 'https://i.ibb.co/9hyH4f9/hozing-room-5.jpg'),
(4002,4,55,150,'Phòng Deluxe Ocean View là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'CONNECTING ROOM', 'https://i.ibb.co/nnPS1vg/hozing-image-10-1.jpg'),
(4003,1,65,110,'Phòng suite room là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'SUPERIOR ROOM', 'https://i.ibb.co/HqdktpX/hozing-image-10-2.jpg'),
(4004,1,65,110,'Phòng Deluxe Ocean View là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'deluxe room', 'https://i.ibb.co/wWM0vDW/Suite-room-1-545x405.jpg'),
(5001,3,55,200,'Phòng Deluxe Ocean View là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'CONNECTING ROOM', 'https://i.ibb.co/vjkrVPn/single-room1-545x405.jpg'),
(5002,3,55,300,'Phòng suite room là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'suite room', 'https://i.ibb.co/gzfb8zX/family-room-545x405.jpg'),
(5003,4,115,100,'Phòng Deluxe Ocean View là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'SUPERIOR ROOM', 'https://i.ibb.co/QKsGsLM/family-room-1-545x405.jpg'),
(6001,3,65,110,'Phòng suite room là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'DOUBLE BED ROOM', 'https://i.ibb.co/QNkMLRk/2001.jpg'),
(6002,3,905,200,'Phòng Deluxe Ocean View là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'FAMILY ROOM', 'https://i.ibb.co/Qf5b746/1009.jpg'),
(6003,3,25,270,'Phòng suite room là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'CONNECTING ROOM', 'https://i.ibb.co/Pwv12QS/1008.jpg'),
(6004,5,25,200,'Phòng Deluxe Ocean View là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'SUITE ROOM', 'https://i.ibb.co/HqQzwFx/1007.jpg'),
(7001,4,65,110,'Phòng suite room là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'FAMILY ROOM', 'https://i.ibb.co/1T9pFLJ/1006.jpg'),
(7002,3,65,100,'Phòng Deluxe Ocean View là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'deluxe room', 'https://i.ibb.co/TwPTCdw/hozing-room-9-2.jpg'),
(7003,3,65,210,'Phòng suite room là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'DELUXE ROOM', 'https://i.ibb.co/xDNcJb0/hozing-room-9-1.jpg'),
(7004,2,65,200,'Phòng Deluxe Ocean View là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'deluxe room', 'https://i.ibb.co/QNkMLRk/2001.jpg'),
(8001,1,200,300,'Phòng suite room là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'DELUXE ROOM', 'https://i.ibb.co/pvNsxFr/hozing-room-8.jpg'),
(8002,2,65,110,'Phòng Deluxe Ocean View là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'deluxe room', 'https://i.ibb.co/h1nhds4/hozing-room-7.jpg'),
(8003,3,65,300,'Phòng suite room là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'CONNECTING ROOM', 'https://i.ibb.co/PTrYgBd/hozing-room-6-2.jpg'),
(8004,5,105,110,'Phòng Deluxe Ocean View là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'deluxe room', 'https://i.ibb.co/1nmB7Vz/hozing-room-6.jpg'),
(9001,5,35,200,'Phòng suite room là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'CONNECTING ROOM', 'https://i.ibb.co/9hyH4f9/hozing-room-5.jpg'),
(9002,3,55,150,'Phòng Deluxe Ocean View là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'CONNECTING ROOM', 'https://i.ibb.co/nnPS1vg/hozing-image-10-1.jpg'),
(9003,2,65,110,'Phòng suite room là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'SUPERIOR ROOM', 'https://i.ibb.co/HqdktpX/hozing-image-10-2.jpg'),
(9004,4,65,110,'Phòng Deluxe Ocean View là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'deluxe room', 'https://i.ibb.co/wWM0vDW/Suite-room-1-545x405.jpg'),
(1101,2,55,200,'Phòng Deluxe Ocean View là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'CONNECTING ROOM', 'https://i.ibb.co/vjkrVPn/single-room1-545x405.jpg'),
(1102,1,55,300,'Phòng suite room là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'suite room', 'https://i.ibb.co/gzfb8zX/family-room-545x405.jpg'),
(1103,2,115,100,'Phòng Deluxe Ocean View là một lựa chọn hoàn hảo cho những ai tìm kiếm 
trải nghiệm xa hoa và tiện nghi cao cấp. 
Với tầm nhìn trực tiếp ra biển cả xanh biếc, 
phòng này mang đến không gian thoải mái và sự sang trọng đích thực.'
,'SUPERIOR ROOM', 'https://i.ibb.co/QKsGsLM/family-room-1-545x405.jpg');

drop table if exists book;
CREATE TABLE book (
    book_id int(11) AUTO_INCREMENT PRIMARY KEY COMMENT 'id dat phong',
    room_code int(11) COMMENT 'ma phong',
    customer_id int(11)COMMENT 'ma khach hang',
   	num_adult int(2) COMMENT 'so luong nguoi lon',
    num_children int(2) COMMENT 'so luong tre em',
    check_in date COMMENT 'gio lam thu tuc check in',
    check_out date COMMENT 'gio check out',
    num_night int(2) COMMENT 'so dem'
);

drop table if exists service_type;
CREATE TABLE service_type (
    type_id int(11) AUTO_INCREMENT PRIMARY KEY COMMENT 'id dich vu',
    name varchar(100) COMMENT 'ten dich vu',
    price decimal(10,0) COMMENT 'gia dich vu',
    unit varchar(20) COMMENT 'don vi'
);

insert into service_type(name, price, unit)
values
("Free-to-use smartphone",0, '$'),
("Safe-deposit box",0 , '$'),
("Luggage storage",0, '$'),
("Childcare",600, '$'),
("Massage",150, '$'),
("Airport shuttle ",200, '$')

drop table if exists feedback;
CREATE TABLE feedback (
    feedback int(11) AUTO_INCREMENT PRIMARY KEY COMMENT 'id dich vu',
    name varchar(100) COMMENT 'ten khach hang',
    phone_number varchar(15) COMMENT 'So dien thoai',
    email varchar(100) COMMENT 'Email',
    note text COMMENT 'Feedback khach hang'
);

drop table if exists mapping_room_service;
CREATE TABLE mapping_room_service (
    mapping_id int(11) AUTO_INCREMENT PRIMARY KEY COMMENT 'id dich vu',
    service_id int(11) COMMENT 'ten service',
    room_code int(11) COMMENT 'ma phong'
);
insert into mapping_room_service (room_code, service_id)
values
(1001,1),(1001,2),(1001,3),(1001,4),(1001,5),(1001,6),
(1002,1),(1002,2),(1002,3),(1002,4),(1002,5),(1002,6),
(1003,1),(1003,2),(1003,3),(1003,4),(1003,5),(1003,6),
(1004,1),(1004,2),(1004,3),(1004,4),(1004,5),(1004,6),
(2001,1),(2001,2),(2001,3),(2001,4),(2001,5),(2001,6),
(2002,1),(2002,2),(2002,3),(2002,4),(2002,5),(2002,6),
(2003,1),(2003,2),(2003,3),(2003,4),(2003,5),(2003,6),
(2004,1),(2004,2),(2004,3),(2004,4),(2004,5),(2004,6),
(3001,1),(3001,2),(3001,3),(3001,4),(3001,5),(3001,6),
(3002,1),(3002,2),(3002,3),(3002,4),(3002,5),(3002,6),
(3003,1),(3003,2),(3003,3),(3003,4),(3003,5),(3003,6),
(3004,1),(3004,2),(3004,3),(3004,4),(3004,5),(3004,6),
(4001,1),(4001,2),(4001,3),(4001,4),(4001,5),(4001,6),
(4002,1),(4002,2),(4002,3),(4002,4),(4002,5),(4002,6),
(4003,1),(4003,2),(4003,3),(4003,4),(4003,5),(4003,6),
(4004,1),(4004,2),(4004,3),(4004,4),(4004,5),(4004,6),
(5001,1),(5001,2),(5001,3),(5001,4),(5001,5),(5001,6),
(5002,1),(5002,2),(5002,3),(5002,4),(5002,5),(5002,6),
(5003,1),(5003,2),(5003,3),(5003,4),(5003,5),(5003,6),
(5004,1),(5004,2),(5004,3),(5004,4),(5004,5),(5004,6),
(6001,1),(6001,2),(6001,3),(6001,4),(6001,5),(6001,6),
(6002,1),(6002,2),(6002,3),(6002,4),(6002,5),(6002,6),
(6003,1),(6003,2),(6003,3),(6003,4),(6003,5),(6003,6),
(6004,1),(6004,2),(6004,3),(6004,4),(6004,5),(6004,6),
(7001,1),(7001,2),(7001,3),(7001,4),(7001,5),(7001,6),
(7002,1),(7002,2),(7002,3),(7002,4),(7002,5),(7002,6),
(7003,1),(7003,2),(7003,3),(7003,4),(7003,5),(7003,6),
(7004,1),(7004,2),(7004,3),(7004,4),(7004,5),(7004,6),
(8001,1),(8001,2),(8001,3),(8001,4),(8001,5),(8001,6),
(8002,1),(8002,2),(8002,3),(8002,4),(8002,5),(8002,6),
(8003,1),(8003,2),(8003,3),(8003,4),(8003,5),(8003,6),
(8004,1),(8004,2),(8004,3),(8004,4),(8004,5),(8004,6),
(9001,1),(9001,2),(9001,3),(9001,4),(9001,5),(9001,6),
(9002,1),(9002,2),(9002,3),(9002,4),(9002,5),(9002,6),
(9003,1),(9003,2),(9003,3),(9003,4),(9003,5),(9003,6),
(9004,1),(9004,2),(9004,3),(9004,4),(9004,5),(9004,6),
(1101,1),(1101,2),(1101,3),(1101,4),(1101,5),(1101,6),
(1102,1),(1102,2),(1102,3),(1102,4),(1102,5),(1102,6),
(1103,1),(1103,2),(1103,3),(1103,4),(1103,5),(1103,6),
(1104,1),(1104,2),(1104,3),(1104,4),(1104,5),(1104,6);

# SELECT * FROM mapping_room_service

