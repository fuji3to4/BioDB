drop database if exists demo; #先にdemoと言う名前のデータベースがあったら削除する
create database demo; #demoという名前のデータベースを作成する

use demo; #demoデータベースを使用する

#テーブルを作成する
create table PDB(pdbID char(4) not null,
				method char(10) not null,
				resolution float,
				chain char(10) not null,
                positions char(10) not null,
				deposited date not null,     #date型という日付用の型。YYYY-MM-DD
                class char(15),
                url text,                    #長い文字列用にtext型(65535文字)がある。管理上・性能上の理由で多用は控えるべき。
		 		primary key(PDBID));           #主キー(primary key)の設定


create table Protein(proteinID int not null auto_increment, #auto_increment（自動番号付け）属性を加えている。
	            	name char(50) not null,
		    		organism char(30) not null,
		    		len int not null,
					fav int not null,
		    		primary key(proteinID));

create table PDB2Protein(pdbID char(4) not null,
                         proteinID int not null,
						primary key(PDBID,proteinID)); #主キーが複合キーの場合キーとなる属性を並べる


insert into PDB values
('1AGW','X-ray','2.40','A/B','456-765','1997-03-25','Enzyme','https://www.rcsb.org/structure/1AGW'),
('1CVS','X-ray','2.80','C/D','141-365','1999-08-24','Membrane','https://www.rcsb.org/structure/1CVS'),
('1A30','X-ray','2.00','A/B','489-587','1998-01-27','Enzyme','https://www.rcsb.org/structure/1A30'),
('1MBE','NMR',null,'A','38-89','1995-05-19','DNA-Binding','https://www.rcsb.org/structure/1MBE'),
('1GUU','X-ray','1.60','A','38-89','2002-01-30','DNA-Binding','https://www.rcsb.org/structure/1A30'),
('1LMB','X-ray','1.80','3/4','2-93','1991-11-05','DNA-Binding','https://www.rcsb.org/structure/1LMB'),
('4RWF','X-ray','1.76','A','31-116','2014-12-03','Membrane','https://www.rcsb.org/structure/4RWF');


insert into Protein values
('1','Fibroblast growth factor receptor 1','Human','822','0'),
('2','Gag-Pol polyprotein','HIV-1','1435','0'),
('3','Transcriptional activator Myb','Mouse','636','0'),
('4','Repressor protein cI','Bacteriophage lambda','237','0'),
('5','Calcitonin gene-related peptide type 1 receptor','Human','461','0');


insert into PDB2Protein values
('1AGW','1'),
('1CVS','1'),
('1A30','2'),
('1MBE','3'),
('1GUU','3'),
('1LMB','4'),
('4RWF','5');
