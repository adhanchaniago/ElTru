/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     07/11/2019 09:25:21                          */
/*==============================================================*/


drop table if exists KELAS;

drop table if exists KELAS_USER;

drop table if exists MATERI;

drop table if exists POST;

drop table if exists USER;

/*==============================================================*/
/* Table: KELAS                                                 */
/*==============================================================*/
create table KELAS
(
   ID_KELAS             int not null,
   NAMA_KELAS           varchar(50) not null,
   DESKRIPSI_KELAS      varchar(200) not null,
   primary key (ID_KELAS)
);

/*==============================================================*/
/* Table: KELAS_USER                                            */
/*==============================================================*/
create table KELAS_USER
(
   ID_KELAS_USER        int not null,
   ID_KELAS             int,
   ID_USER              int,
   primary key (ID_KELAS_USER)
);

/*==============================================================*/
/* Table: MATERI                                                */
/*==============================================================*/
create table MATERI
(
   ID_MATERI            int not null,
   ID_USER              int,
   ID_KELAS             int,
   ID_POST              int,
   NAMA_MATERI          varchar(100) not null,
   primary key (ID_MATERI)
);

/*==============================================================*/
/* Table: POST                                                  */
/*==============================================================*/
create table POST
(
   ID_POST              int not null,
   ID_KELAS             int,
   ID_USER              int,
   ISI_POST             varchar(300) not null,
   primary key (ID_POST)
);

/*==============================================================*/
/* Table: USER                                                  */
/*==============================================================*/
create table USER
(
   ID_USER              int not null,
   E_MAIL               varchar(50) not null,
   PASSWORD             varchar(50) not null,
   LEVEL                blob not null,
   primary key (ID_USER)
);

alter table KELAS_USER add constraint FK_MASUK foreign key (ID_USER)
      references USER (ID_USER) on delete restrict on update restrict;

alter table KELAS_USER add constraint FK_MENGIKUTI foreign key (ID_KELAS)
      references KELAS (ID_KELAS) on delete restrict on update restrict;

alter table MATERI add constraint FK_MEMPUNYAI foreign key (ID_KELAS)
      references KELAS (ID_KELAS) on delete restrict on update restrict;

alter table MATERI add constraint FK_MENGIRIM foreign key (ID_USER)
      references USER (ID_USER) on delete restrict on update restrict;

alter table MATERI add constraint FK_TERDAPAT foreign key (ID_POST)
      references POST (ID_POST) on delete restrict on update restrict;

alter table POST add constraint FK_MELAKUKAN foreign key (ID_USER)
      references USER (ID_USER) on delete restrict on update restrict;

alter table POST add constraint FK_MEMILIKI foreign key (ID_KELAS)
      references KELAS (ID_KELAS) on delete restrict on update restrict;

