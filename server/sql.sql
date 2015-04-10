drop database device_controls;
create database device_controls;
use device_controls;
drop table controls;
create table controls (
  id int AUTO_INCREMENT,
  mac_code varchar(255),
  password varchar(255),
  name varchar(255),
  created_at datetime,
  updated_at datetime,
  primary key(id)
);

drop table devices;
create table devices (
  id int AUTO_INCREMENT,
  control_id int,
  device_id int,
  action_id int,
  request_time datetime,
  name varchar(255),
  state int,
  message varchar(255),
  created_at datetime,
  updated_at datetime,
  primary key(id)
);

drop table actions;
create table actions (
  id int AUTO_INCREMENT,
  remote_type varchar(255),
  control_id int,
  device_ids varchar(255),
  device_states varchar(255),
  state varchar(50),
  created_at datetime,
  updated_at datetime,
  primary key(id)
);

insert into controls (mac_code, password, name)
  values ('mac_code', 'password', 'control1'), ('mac_code2', 'password2', 'control2');
insert into devices (control_id, device_id, name, state, message)
  values (1, 1, 'device', 1, 'message'), (1, 2, 'device2', 0, NULL);
insert into actions (remote_type, control_id, device_ids, device_states, state)
  values ('pc', 1, '1,1', '0,1', 'new');