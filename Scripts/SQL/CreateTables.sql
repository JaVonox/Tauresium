CREATE TABLE provinces(
Province_ID varchar(255) PRIMARY KEY NOT NULL,
Vertex_1 varchar(100) NOT NULL,
Vertex_2 varchar(100) NOT NULL,
Vertex_3 varchar(100) NOT NULL,
Coastal BOOLEAN,
Capital varchar(100) NOT NULL,
Climate varchar(100) NOT NULL,
Region varchar(100) NOT NULL,
Coastal_Region varchar(100) NOT NULL,
Description TEXT NOT NULL,
City_Population_Total int NOT NULL,
National_HDI FLOAT NOT NULL,
National_Nominal_GDP_per_capita int NOT NULL,
Culture_Modifier FLOAT NOT NULL,
Economic_Enviroment_Modifier FLOAT NOT NULL,
Military_Enviroment_Modifier FLOAT NOT NULL,
Culture_Value FLOAT NOT NULL, /* To be removed*/
Economic_Value FLOAT NOT NULL, /* To be removed */
Military_Value FLOAT NOT NULL, /* To be removed */
Culture_PercentRank FLOAT NOT NULL, /* to be removed */
Economic_PercentRank FLOAT NOT NULL, /* to be removed */
Military_PercentRank FLOAT NOT NULL, /* to be removed */
Culture_Cost int NOT NULL,
Economic_Cost int NOT NULL,
Military_Cost int NOT NULL
);

CREATE TABLE players(
Country_Name varchar(50) PRIMARY KEY NOT NULL,
Hashed_Password varchar(64) NOT NULL,
Country_Type varchar(50) NOT NULL, /*FK*/
Colour varchar(6) NOT NULL,
World_Code varchar(16) NOT NULL, /*FK*/
Military_Influence int NOT NULL,
Military_Generation FLOAT NOT NULL,
Culture_Influence int NOT NULL,
Culture_Generation FLOAT NOT NULL,
Economic_Influence int NOT NULL,
Economic_Generation FLOAT NOT NULL,
Last_Event_Time DATETIME NOT NULL,
events_Stacked FLOAT NOT NULL,
Active_Event_ID int /*FK*/
);

CREATE TABLE worlds(
World_Code varchar(16) PRIMARY KEY NOT NULL,
World_Name varchar(20) NOT NULL,
MapType varchar(16) NOT NULL,
Speed int NOT NULL,
Capacity int NOT NULL
);

CREATE TABLE governmentTypes(
GovernmentForm varchar(50) PRIMARY KEY NOT NULL,
Title TEXT NOT NULL,
Base_Military_Generation FLOAT NOT NULL,
Base_Culture_Generation FLOAT NOT NULL,
Base_Economic_Generation FLOAT NOT NULL,
Base_Military_Influence int NOT NULL,
Base_Culture_Influence int NOT NULL,
Base_Economic_Influence int NOT NULL
);

CREATE TABLE province_Occupation(
Occupation_ID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
World_Code varchar(16) NOT NULL, /*FK*/
Province_ID varchar(255) NOT NULL, /*FK*/
Country_Name varchar(50) NOT NULL, /*FK*/
Province_Type varchar(20) NOT NULL, /*Culture,Economic,Military based on highest base cost*/
Building_Column_1 varchar(2) NOT NULL, /* Starts C0/E0/M0 FK */
Building_Column_2 varchar(2) NOT NULL /* Starts C0/E0/M0 FK */
);

/*Culture Province -> Culture/Military */
/*Economic Province -> Economic/Culture */
/*Military Province -> Military/Economic */

CREATE TABLE buildings(
BuildingID varchar(2) PRIMARY KEY, /* C/E/M + 0/1/2/3/4 */
Building_Name varchar(50),
Bonus_Mil_Cap int NOT NULL,
Bonus_Def_Strength int NOT NULL,
Bonus_Build_Cost int NOT NULL,
Base_Cost int NOT NULL
);

CREATE TABLE events(
Event_ID int PRIMARY KEY NOT NULL AUTO_INCREMENT,
Title TEXT NOT NULL,
Description TEXT NOT NULL,
Base_Influence_Reward int NOT NULL,
Option_1_ID int, /*FK*/
Option_2_ID int, /*FK*/
Option_3_ID int /*FK*/
);

CREATE TABLE options(
Option_ID int PRIMARY KEY NOT NULL,
Option_Description TEXT NOT NULL,
Culture_Gen_Modifier FLOAT NOT NULL,
Economic_Gen_Modifier FLOAT NOT NULL,
Military_Gen_Modifier FLOAT NOT NULL
); 

CREATE TABLE coastalRegions
(
Coastal_Region varchar(100) PRIMARY KEY NOT NULL,
Colonial_Penalty int, /* This is how much extra eco it costs to set up the first province in this location. It is a flat extra cost */
Minimum_Colony_provinces int, /* This is how many coastal provinces a player must own to use this location to travel to new costal regions*/
Short_Range_Penalty int, /* This is the extra cost for setting up any additional provinces in a location when there is no adjacency */
Colonial_Title varchar(100), /* When a player gets enough coastal provinces they get this title in their worldview */
Outbound_Connection_1 varchar(100), /* A coastal region can have up to five outbound connections. These define purely where a nation with sufficient Min colony provinces can travel to from this location */
Outbound_Connection_2 varchar(100),
Outbound_Connection_3 varchar(100),
Outbound_Connection_4 varchar(100),
Outbound_Connection_5 varchar(100)
);

/*
One to One - Foreign key on one side (both) Does not work in VM. Do one to many instead.
One to Many - Foreign key on Many side to link to One
Many to Many - Buffer table to convert to One to Many
*/

/* One to Many - One World to Many players */

ALTER TABLE players
add constraint playersM_to_WorldO
foreign key(World_Code)
references worlds(World_Code);

/* One to Many - One GovernmentType to Many players */

ALTER TABLE players
add constraint playersM_to_governmentTypesO
foreign key(Country_Type)
references governmentTypes(GovernmentForm);

/* One to One - One EventOption to One Option(s) */

ALTER TABLE events
add constraint EventOption1_OptionID
foreign key(Option_1_ID)
references options(Option_ID);

ALTER TABLE events
add constraint EventOption2_OptionID
foreign key(Option_2_ID)
references options(Option_ID);

ALTER TABLE events
add constraint EventOption3_OptionID
foreign key(Option_3_ID)
references options(Option_ID);

/* Many to one - one event to many players */

ALTER TABLE players
add constraint playersM_to_EventIDO
foreign key(Active_Event_ID)
references events(Event_ID);

/*Province Occupation relations */

/* Many to one. Many provinces to one province ID */

ALTER TABLE province_Occupation
add constraint ProvinceOcc_ProvID_M_To_Prov_IDO
foreign key(Province_ID)
references provinces(Province_ID);

/* Many to one. Many WorldCodes to one WorldCode */

ALTER TABLE province_Occupation
add constraint ProvinceOcc_WC_M_To_worlds_WCO
foreign key(World_Code)
references worlds(World_Code);

/* Many to one. Many ProvOcc country to one country */

ALTER TABLE province_Occupation
add constraint ProvinceOcc_Count_M_To_players_CountCO
foreign key(Country_Name)
references players(Country_Name);

/* One to Many. One coastal can have many provinces  */
ALTER TABLE provinces
add constraint provincesCR_M_To_coastalRegionsCR_O
foreign key(Coastal_Region)
references coastalRegions(Coastal_Region);

/* Many to One. Many Building_Columns to One building */

ALTER TABLE province_Occupation
add constraint ProvinceOcc_B1_M_To_Buildings_ID_O
foreign key(Building_Column_1)
references buildings(BuildingID);

ALTER TABLE province_Occupation
add constraint ProvinceOcc_B2_M_To_Buildings_ID_O
foreign key(Building_Column_2)
references buildings(BuildingID);

INSERT INTO options VALUES(1,'These rebels should be removed from their offices at once',-0.04,0,0.04);
INSERT INTO options VALUES(2,'Our government must be open to all opinions',0.03,0.02,-0.06);
INSERT INTO options VALUES(3,'Perhaps we can pretend they simply do not exist',-0.01,-0.01,-0.01);

INSERT INTO events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Dissidents In Our Government',
'Recent investigations have confirmed the existence of high ranking officials opposed to official government policy, having such persons in our administration threatens to undermine our authority, what actions should we take with these dissidents?',
50,1,2,3);

INSERT INTO options VALUES(4,'Release evidence disproving the baseless rumours',-0.05,0,0.02);
INSERT INTO options VALUES(5,'It is just a harmless rumor, perhaps we can just let the people imagine?',0.04,0,-0.01);
INSERT INTO options VALUES(6,'Excavate the site to disprove the rumor once and for all',-0.03,-0.04,0.03);

INSERT INTO events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Riches Untold',
'Spurred on by a popular tabloid, rumours have begun to circulate that under a recently constructed town lies a large amount of gold. Our Advisors assure us that there is no such thing, but yet the public still calls for us to demolish and excavate the site.',
30,4,5,6);

INSERT INTO options VALUES(7,'Send a police task force to deal with them',0.02,0,0.03);
INSERT INTO options VALUES(8,'Threaten to cut vital subsidies to the region',0.01,-0.02,0.01);
INSERT INTO options VALUES(9,'Allow them to practice what they wish',-0.03,0.02,0);

INSERT INTO events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Counter Culture',
'Recently, an obscure village on the fringes of our country have began to develop traditions of their own, many of which contradict our peoples own beliefs. Public outcry has called for us to suppress these so called harmful revolutionaries.',
40,7,8,9);

INSERT INTO options VALUES(10,'Nonsense! These unique and beautiful animals will be our new national animal!',0.04,-0.04,0);
INSERT INTO options VALUES(11,'Cull the population to acceptable levels',-0.01,0.03,0);
INSERT INTO options VALUES(12,'This is really not an issue of national importance, they can deal with it how they see fit.',0,0.01,0);

INSERT INTO events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Creature Comforts',
'Zoologists under our funding have discovered a new species of freshwater fish native to rivers in our nation. Since the discovery of these fish, their population has skyrocketed, harming local ecosystems. Local communities have asked us to intervene to protect their interests in the area.',
25,10,11,12);

INSERT INTO options VALUES(13,'Blockading the nuclear plant is putting them in more danger than any fake symptoms, they must be dispersed by force.',0,0.02,0.03);
INSERT INTO options VALUES(14,'Agree to demolish the plant to appease the people',0.02,-0.05,-0.02);
INSERT INTO options VALUES(15,'There cannot be *nothing* causing their illness, fund an investigation into the true causes of the symptoms',0.01,-0.01,-0.01);

INSERT INTO events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Placebo Particle',
'After the installation of a nuclear power plant near a rural town locals have began to complain of frequent headaches and pains, and in some cases even vomiting. Investigation into the matter has cleared any suspicion of radiation-related causes, yet the locals have organised a blockade of the facility in protest, the power company has turned to us for help in this crisis.',
45,13,14,15);

INSERT INTO options VALUES(16,'We cannot allow our children to believe such nonsense',-0.01,0.03,0);
INSERT INTO options VALUES(17,'Of course! Teaching all sides of a debate teaches children critical thinking skills.',0.02,-0.05,0);
INSERT INTO options VALUES(18,'School should only be for teaching productive skills. We should remove all irrelevant subjects from the curriculum',-0.06,0.06,0.02);

INSERT INTO events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Teach The Controversy',
'A small group of protesters have gathered to demand public education include modules on their frighteningly misguided conspiracy theories, calling the lack of such topics censorship',
30,16,17,18);

INSERT INTO options VALUES(19,'Duels are an archaic system that cannot be permitted within a modern nation.',-0.03,0.03,-0.03);
INSERT INTO options VALUES(20,'Such a rich part of our history cannot be ignored. Duels should be legal once more.',0.05,-0.05,0.02);
INSERT INTO options VALUES(21,'Duels should only be permitted to those who hold military positions, perhaps they can serve as an alternate method of training?',0,-0.01,0.03);

INSERT INTO events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Quality Of Strife',
'An obscure murder trial has sparked national controversy after the defence team declared it a consentual duel between adults, resulting in a not guilty verdict. All participants in the trial have been disbarred for their actions which clearly violate state law, but some protesters claim the verdict should be maintained, and furthermore, dueling should be legalised between consenting partners.',
40,19,20,21);

INSERT INTO options VALUES(22,'Our land is *our* land.',0.02,0,0.03);
INSERT INTO options VALUES(23,'The land in question is not in use, perhaps we can loan some territory to the villagers. For a price, of course.',-0.02,0.04,-0.01);
INSERT INTO options VALUES(24,'Surrender the land in the name of peace, we had no need for it anyway.',0.02,0,-0.04);

INSERT INTO events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Territorial Extent',
'A foreign group of settlers have erected a new village near our national borders. This would not normally be an issue, but the villagers are claiming that some fertile land within our borders should belong to them, due to its lack of development and closeness to the town. Media pressure has forced us to confront this issue and release a response to the incident.',
40,22,23,24);

INSERT INTO options VALUES(25,'Grant them their wish. They created the technology, and so should have say on how it is used.',0.05,-0.03,0);
INSERT INTO options VALUES(26,'The device could not even have been invented without our help, it should be free to all nations.',0.01,0.03,-0.01);
INSERT INTO options VALUES(27,'This is an invention of our country, and the production rights belong to our country alone.',-0.03,0.04,0.04);

INSERT INTO events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Technophilia',
'One of our top national universities has unveiled a startling invention - a prosthetic limb capable of perfect one to one motion, with joints perfectly capable of recreating human level movement. The team behind this revolutionary technology primarily consists of foreign scholarship students, who have requested the exclusive production rights be granted to their home country.',
50,25,26,27);

INSERT INTO options VALUES(28,'Who says it has to be purely defensive? This technology could give us the upper hand in global conflicts...',-0.02,-0.03,0.06);
INSERT INTO options VALUES(29,'Modernising the nation is certainly important, but the costs outweigh the benefits.',0,0.03,-0.03);
INSERT INTO options VALUES(30,'Funding this project is essential to maintaining the safety of our nation.',0.01,-0.04,0.04);

INSERT INTO events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('A New Form Of Warfare',
'Following a recent cyberattack on a foreign nation, which temporarily disabled energy distribution to an entire city, our military advisors have suggested we form of branch of military dedicated to defense against cyberattacks, lest a similar situation happen to us. The iniative would certainly be expensive however, as it requires funding an entirely new war department.',
60,28,29,30);

INSERT INTO options VALUES(31,'Bury it. We cannot harm this beautiful landscape more than we already have',0.06,-0.03,-0.02);
INSERT INTO options VALUES(32,'Authorise the extraction and sale of small quantities at a time, while being careful not to damage the local ecosystem.',-0.01,0.04,0);
INSERT INTO options VALUES(33,'We always have more national parks. Tear the place up and hire a professional drilling company to extract all we can.',-0.05,0.03,0.02);

INSERT INTO events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Black Gold',
'An illegal drilling operation in a wildlife conservation zone has discovered a large supply of oil under said national park. While the perpetrators originally tried to hide their discovery, locals quickly spread the news and the drilling team has been arrested. The question remains, what do we do with all this newfound oil?',
50,31,32,33);

INSERT INTO options VALUES(34,'Release the document. I am sure our friends will be quite appriciative.',-0.03,0.03,0.05);
INSERT INTO options VALUES(35,'Pretend we never saw the letter. It is not worth getting involved in foreign squabbles.',0.03,0,-0.02);
INSERT INTO options VALUES(36,'We could all stand to make a lot of money were we to ransom this document to its sender.',-0.05,0.07,0.03);

INSERT INTO events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Return To Sender',
'Our military decryption specialists have uncovered a communication between a foreign power and their ally. The message requests for aid in an immenent attack on their mutual enemy. Said enemy is an important economic partner of ours, and we could benefit greatly from releasing this information, but it certainly would not make us any friends.',
50,34,35,36);

INSERT INTO options VALUES(37,'The extra revenue from this deal could be used to directly benefit the people. Does it really matter where the money came from?',-0.06,0.06,0);
INSERT INTO options VALUES(38,'We are willing to negotiate, but if this conversation leaks, there will be consequences.',-0.03,0.04,0.03);
INSERT INTO options VALUES(39,'This is blatant corruption',0.04,-0.04,-0.01);

INSERT INTO events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Private Correspondence',
'An international company has offered some interesting rewards, were we to wait until a certain date to enact a regulation currently under review. This would provide significant new funding for our government, but would be blatant corporate favouritism were it to be discovered.',
35,37,38,39);

INSERT INTO options VALUES(40,'A full investigation should be done, and the instigators should face consequences',0.01,0,0.03);
INSERT INTO options VALUES(41,'Most likely this was an act of drunks or teenagers. Chasing up the criminals will do nothing to help, we should focus on recovery',0.04,0.01,-0.03);
INSERT INTO options VALUES(42,'This newly free land would be the perfect place for a new housing estate',-0.04,0.06,0);

INSERT INTO events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Watergate Scandal',
'During the night, a local reservoir was destroyed as an unknown group released the floodgates during the night. Though thankfully not impacting any residents, the resulting flood significantly damaged the local wildlife. The actors in this scheme are not yet known, but evidence points that the damage was done intentionally',
20,40,41,42);

INSERT INTO options VALUES(43,'If the people behind this attack want to spend money on criticising our nation, they can do so as they please.',0.04,-0.02,-0.02);
INSERT INTO options VALUES(44,'Ban the commercial from airing. This is an innapropriate use of technology.',-0.06,0.02,0.04);
INSERT INTO options VALUES(45,'Acknowledge the advertisement publicly and laugh off the criticisms.',0.05,-0.02,-0.04);

INSERT INTO events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('National Ridicule',
'Last night, a satirical advertisement was ran on television networks nationwide. The advertisement did not seem to attempt to sell or promote any product, and simply criticised government policy for minutes on end before abruptly ending. What actions shall we take in response to this?',
40,43,44,45);

INSERT INTO options VALUES(46,'This is akin to giving up national sovereignty',-0.03,0.04,0.02);
INSERT INTO options VALUES(47,'Expel the embassy for these utterly inappropriate comments',-0.06,0,0.06);
INSERT INTO options VALUES(48,'Ethnic groups should be able to decide their own rights and responsibilities, with oversight from our government of course',0.05,0,-0.05);

INSERT INTO events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Diplomancy',
'Recently, an embassy stationed in our capital has gained significant backlash for an comment made by an official stating that ethnic groups within our nation should be subject to the laws of their homeland. This offhand statement has incited national debate, and while the official who originally made the statement has backed down from this stance, we are still expected to release an announcement regarding the controversy',
45,46,47,48);

INSERT INTO options VALUES(49,'Seize the homes and release them at a discounted price to homeless persons',0.03,-0.04,0.04);
INSERT INTO options VALUES(50,'Enact a law restricting the maximum amount of homes a person or company can own',0.06,-0.03,0.01);
INSERT INTO options VALUES(51,'These properties were aquired lawfully, we cannot simply take them from their owners',-0.03,0.05,0);

INSERT INTO events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Forced Philanthropy',
'It has come to the attention of our government that, while homelessness has never been higher within our nation, there are many unoccupied houses belonging to various landlords and companies. Were we to release even a fraction of these houses, homelessness in our country would drop significantly.',
45,49,50,51);

INSERT INTO options VALUES(52,'Now more than ever, our citizens need to eat healthily. If we do not provide subsidies we are punishing our people more than we are punishing the company',0.03,0.03,-0.04);
INSERT INTO options VALUES(53,'Arrest the head and grant subsidies to his replacement',0,0.03,0.06);
INSERT INTO options VALUES(54,'Our citizens need food, and that is the exact reason why we should aquire the company as a government run business',-0.04,0.02,0.03);

INSERT INTO events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Sheepish',
'This morning our department incharge of agricultural affairs recieved a worrying email. The email came from the head of a local farming conglomerate who admitted he had personally gambled away the farming subsidies provided to his business, and with a looming rise in demand for agricultural goods, he has come to humbly request we grant him more subsidies.',
30,52,53,54);

INSERT INTO options VALUES(55,'We cannot allow romance in military action',-0.06,0,0.05);
INSERT INTO options VALUES(56,'We should only permit married individuals into military office, we could have our own modern Sacred Band of Thebes',0.03,0,0.03);
INSERT INTO options VALUES(57,'Does it truly matter? Trained professionals are unlikely to be distracted when their lives are on the line',0.05,0,-0.06);

INSERT INTO events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Tough Love',
'A high ranking naval commander was recently revealed to be having an affair with a member of his crew. The rest of his crew claim that this had no bearing on his performance as a commander, but there is still cause for concern, any distractions during wartime could be fatal.',
30,55,56,57);

INSERT INTO options VALUES(58,'These events are a time for national celebration, it will be worth it no matter the cost.',0.08,-0.08,0);
INSERT INTO options VALUES(59,'If we increase ticket prices and tax the local area higher than usual, we might be able to make our money back and then some',0.03,0.01,0.03);
INSERT INTO options VALUES(60,'We cannot host the event, the financial burden would be too great',-0.05,0.05,0);

INSERT INTO events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('The Games',
'An international sporting event has decided that our capital will be the host of their next competition. Should we accept the invitation, it would be our financial responsibility to provide necessary stadium, services and equipment. This would likely be incredibly expensive, and all ready we have protesters demanding we deny the invitation',
50,58,59,60);

INSERT INTO options VALUES(61,'Hire new mine workers to replace the striking employees',-0.02,0.04,0.01);
INSERT INTO options VALUES(62,'Cave in to their demands',0.06,-0.04,-0.02);
INSERT INTO options VALUES(63,'Force the miners back to work, by violent action if neccessary',-0.05,0.03,0.05);

INSERT INTO events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('A Miner Issue',
'After an accident which temporarily trapped some miners underground for 48 hours, miners across our nation have began to protest their working conditions. Until now, the mining industry has largely profitted off the weak national guidelines, allowing them to pay workers little in return for dangerous work.',
30,61,62,63);

INSERT INTO options VALUES(64,'Mandatory military service will make our people strong and capable',-0.04,-0.03,0.05);
INSERT INTO options VALUES(65,'We cannot force our citizens to fight for us',0.06,0.03,-0.03);
INSERT INTO options VALUES(66,'Perhaps we can hire armies from other nations to fight on our behalf?',-0.01,-0.01,0.02);

INSERT INTO events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Lord Kitchner Wants You',
'The number of enlistees joining our national military has dropped tremendously in recent months, and seems to only get lower each day. While such measures have usually only been enacted during wartime, some officials are recommending we begin mandatory enlistment to ensure our army is strong enough to protect the nation.',
40,64,65,66);

INSERT INTO options VALUES(67,'Punish tree thieves with property damage and theft as a deterrent',-0.07,0.02,0.05);
INSERT INTO options VALUES(68,'Fund plastic tree commercials to direct public attention away from real trees',-0.03,0.05,0);
INSERT INTO options VALUES(69,'Plant replacements and allow the theft to go unpunished',0.04,-0.03,-0.02);

INSERT INTO events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Piracy On The High Trees',
'In certain regions of our nation, there have been reports of small scale deforestation as more citizens begin to steal trees for use in winter traditions. There has not yet been significant enviromental impact, but the forestry industry has come to us for help, citing a loss in profits due to the thieves.',
20,67,68,69);

INSERT INTO coastalRegions VALUES ("America North",50,5,30,"American Artic Ocean","America West","North Atlantic",NULL,NULL,NULL);
INSERT INTO coastalRegions VALUES ("America East",70,4,20,"Sargasso Sea","Europe","North Atlantic",NULL,NULL,NULL);
INSERT INTO coastalRegions VALUES ("America West",50,3,40,"North Pacific Ocean","America North",NULL,NULL,NULL,NULL);
INSERT INTO coastalRegions VALUES ("China Sea",70,6,40,"Asian Pacific Ocean","South East Asia",NULL,NULL,NULL,NULL);
INSERT INTO coastalRegions VALUES ("East Africa",40,4,20,"East African Sea","Indian",NULL,NULL,NULL,NULL);
INSERT INTO coastalRegions VALUES ("Europe",50,6,60,"European Oceans","America East","North Atlantic",NULL,NULL,NULL);
INSERT INTO coastalRegions VALUES ("Indian",100,6,60,"Indian Ocean","East Africa","South East Asia",NULL,NULL,NULL);
INSERT INTO coastalRegions VALUES ("Mexico",50,3,60,"Caribbean Sea","America East","America West","South America West","South America East","West Africa");
INSERT INTO coastalRegions VALUES ("North Atlantic",25,4,10,"Atlantic Ocean","Europe","America East","America North",NULL,NULL);
INSERT INTO coastalRegions VALUES ("South America East",40,4,30,"South Atlantic","West Africa",NULL,NULL,NULL,NULL);
INSERT INTO coastalRegions VALUES ("South America West",50,3,35,"South Pacific",NULL,NULL,NULL,NULL,NULL);
INSERT INTO coastalRegions VALUES ("South East Asia",60,6,40,"South East Asian Ocean","Indian","China Sea",NULL,NULL,NULL);
INSERT INTO coastalRegions VALUES ("Steppes",50,4,40,"Artic Ocean",NULL,NULL,NULL,NULL,NULL);
INSERT INTO coastalRegions VALUES ("West Africa",40,5,30,"West African Sea","Mexico","South America East",NULL,NULL,NULL);

INSERT INTO governmentTypes VALUES('Sultanate','The Sultanate of',0.9,1.4,0.8,100,200,0);
INSERT INTO governmentTypes VALUES('Horde','The Great Horde of',1,1.4,0.6,0,300,0);
INSERT INTO governmentTypes VALUES('ElectoralMonarchy','The Electoral Kingdom of',1.1,1.3,0.6,180,70,0);
INSERT INTO governmentTypes VALUES('Theocracy','The Prince bishopric of',0.9,1.2,1,50,200,0);
INSERT INTO governmentTypes VALUES('Monarchy','The Kingdom of',1,1.1,1,80,100,50);
INSERT INTO governmentTypes VALUES('Libertarian','The Free State of',0.8,0.8,1.4,50,70,150);
INSERT INTO governmentTypes VALUES('Colonial','The Colonial Domain of',0.8,1,1.3,100,100,100);
INSERT INTO governmentTypes VALUES('Democracy','The Democratic Republic of',1,0.8,1.3,0,70,150);
INSERT INTO governmentTypes VALUES('MerchantRepublic','The Mercantile Republic of',0.9,1,1.2,50,80,120);
INSERT INTO governmentTypes VALUES('ClassicRepublic','The Republic of',1,1,1.1,70,70,100);
INSERT INTO governmentTypes VALUES('Dictatorship','The Nation of',1.3,0.9,0.9,150,30,50);
INSERT INTO governmentTypes VALUES('CommunistRepublic','The Peoples Republic of',1.2,1.2,0.6,150,70,0);
INSERT INTO governmentTypes VALUES('Oligarchy','The Oligarchical State of',1.1,1,1,100,50,70);
INSERT INTO governmentTypes VALUES('Anarchy','The Free Communities of',0.9,0.9,0.9,25,25,25);
INSERT INTO governmentTypes VALUES('Tribe','The Tribe of',0.8,0.8,0.8,0,0,0);

INSERT INTO buildings VALUES('C0','Administration','0','0','0','0');
INSERT INTO buildings VALUES('C1','Cathedral','0','20','10','50');
INSERT INTO buildings VALUES('C2','Train Station','10','0','0','100');
INSERT INTO buildings VALUES('C3','University','0','80','25','200');
INSERT INTO buildings VALUES('C4','Airport','15','0','0','400');

INSERT INTO buildings VALUES('E0','Administration','0','0','0','0');
INSERT INTO buildings VALUES('E1','Bank','0','40','0','50');
INSERT INTO buildings VALUES('E2','Factory','0','0','15','100');
INSERT INTO buildings VALUES('E3','Stock Exchange','0','100','0','200');
INSERT INTO buildings VALUES('E4','International Headquaters','0','60','10','400');

INSERT INTO buildings VALUES('M0','Administration','0','0','0','0');
INSERT INTO buildings VALUES('M1','Military Base','10','0','0','50');
INSERT INTO buildings VALUES('M2','Airfield','10','100','0','100');
INSERT INTO buildings VALUES('M3','Logistics Office','15','0','15','200');
INSERT INTO buildings VALUES('M4','Command Center','0','200','0','400');

INSERT INTO provinces  VALUES ('Alaska_BristolBay','5,100','31,68','43,87',TRUE,'Bethel','Tundra','Alaska','America North','>No Information Currently Available','6000','0.926','63051','0','-0.1','0','55.56','588.93226','32.72107637','0.4166','9.2361','1.2962','56','75','57');
INSERT INTO provinces  VALUES ('Alaska_Calista','31,68','56,67','52,50',TRUE,'Kotzebue','Tundra','Alaska','America North','>No Information Currently Available','3200','0.926','63051','0','-0.1','0','29.632','613.22826','18.1711798','0.2546','9.5601','0.7638','56','75','57');
INSERT INTO provinces  VALUES ('Alaska_WestDoyon','43,87','31,68','56,67',FALSE,'Fairbanks','Tundra','Alaska','America North','>No Information Currently Available','32000','0.926','63051','0','-0.1','0','296.32','627.61226','185.9740649','1.0416','9.7453','3.449','57','75','60');
INSERT INTO provinces  VALUES ('Alaska_Chugach','43,87','74,89','56,67',TRUE,'Anchorage','Taiga','Alaska','America North','>No Information Currently Available','290000','0.926','63051','0','-0.05','0','2685.4','596.05226','1600.638739','3.9351','9.375','7.3379','62','79','82');
INSERT INTO provinces  VALUES ('Alaska_ArticSlope','76,44','52,50','56,67',TRUE,'Utqiagvik','Tundra','Alaska','America North','>No Information Currently Available','4200','0.926','63051','0','-0.1','0','38.892','622.40826','24.20670205','0.324','9.699','1.0185','56','75','57');
INSERT INTO provinces  VALUES ('Alaska_Doyon','56,67','77,44','74,89',FALSE,'Juneau','Taiga','Alaska','America North','>No Information Currently Available','31000','0.926','63051','0','-0.05','0','287.06','618.43226','177.5271646','0.9953','9.6064','3.3101','57','79','60');
INSERT INTO provinces  VALUES ('Canada_Yukon','74,89','77,44','98,91',FALSE,'Whitehorse','Taiga','Yukon','America North','>No Information Currently Available','25000','0.929','42080','0','-0.05','0','232.25','440.1732','102.2302257','0.8564','8.2175','2.2453','57','79','58');
INSERT INTO provinces  VALUES ('Canada_NorthWestTerritoriesWest','77,44','98,91','121,50',TRUE,'Inuvik','Tundra','Northwest territories','America North','>No Information Currently Available','3200','0.929','42080','0','-0.1','0','29.728','410.0272','12.1892886','0.2777','7.9166','0.5555','56','74','57');
INSERT INTO provinces  VALUES ('Canada_NorthWestTerritoriesCenter','151,91','98,91','121,50',FALSE,'Yellowknife','Tundra','Northwest territories','America North','>No Information Currently Available','19000','0.929','42080','0','-0.1','0','176.51','404.3532','71.37238333','0.7407','7.824','1.8287','57','74','57');
INSERT INTO provinces  VALUES ('Canada_NunavutWest','121,50','161,55','151,91',TRUE,'Cambridge Bay','Tundra','Nunavut','America North','>No Information Currently Available','1700','0.929','42080','0','-0.1','0','15.793','401.0722','6.334133255','0.1851','7.7314','0.3703','56','74','56');
INSERT INTO provinces  VALUES ('Canada_Nunavut','221,57','161,55','151,91',TRUE,'Iqaluit','Tundra','Nunavut','America North','>No Information Currently Available','7700','0.929','42080','0','-0.1','0','71.533','436.8922','31.25220974','0.4861','8.125','1.2268','56','74','57');
INSERT INTO provinces  VALUES ('Canada_BritishColumbiaWest','76,130','74,89','98,91',TRUE,'Vancouver','Taiga','British Columbia','America North','>No Information Currently Available','670000','0.929','42080','0','-0.05','0','6224.3','440.8232','2743.815844','5.9027','8.2638','8.0555','77','79','83');
INSERT INTO provinces  VALUES ('Canada_BritishColumbiaEast','76,130','113,129','98,91',FALSE,'Kelowna','Taiga','British Columbia','America North','>No Information Currently Available','140000','0.929','42080','0','-0.05','0','1300.6','426.7232','554.9961939','2.4537','8.0787','5.6018','58','78','75');
INSERT INTO provinces  VALUES ('Canada_Alberta','151,91','113,129','98,91',FALSE,'Edmonton','Taiga','Alberta','America North','>No Information Currently Available','930000','0.929','42080','0','-0.05','0','8639.7','393.0232','3395.602541','6.8055','7.6157','8.4027','81','78','83');
INSERT INTO provinces  VALUES ('Canada_Saskatchewan','151,91','113,129','132,128',FALSE,'Saskatoon','Taiga','Sasketchewan','America North','>No Information Currently Available','240000','0.929','42080','0','-0.05','0','2229.6','423.7232','944.7332467','3.5648','8.0555','6.5277','60','78','80');
INSERT INTO provinces  VALUES ('Canada_ManitobaNorth','132,128','151,91','186,75',FALSE,'Thompson','Taiga','Manitoba','America North','>No Information Currently Available','13000','0.929','42080','0','-0.05','0','120.77','418.5332','50.54625456','0.5787','8.0092','1.5509','57','78','57');
INSERT INTO provinces  VALUES ('Canada_ManitobaSouth','132,128','183,125','186,75',FALSE,'Winnipeg','Taiga','Manitoba','America North','>No Information Currently Available','700000','0.929','42080','0','-0.05','0','6503','419.9232','2730.76057','5.9953','8.0324','8.0324','78','78','83');
INSERT INTO provinces  VALUES ('Canada_ManitobaEast','202,101','183,125','186,75',TRUE,'Churchill','Taiga','Manitoba','America North','>No Information Currently Available','900','0.929','42080','0','-0.05','0','8.361','396.2962','3.313432528','0.0925','7.6851','0.2546','56','78','56');
INSERT INTO provinces  VALUES ('Canada_OntarioWest','202,101','183,125','198,124',FALSE,'Toronto','Taiga','Ontario','America North','>No Information Currently Available','2900000','0.929','42080','0','-0.05','0','26941','403.9232','10882.09493','8.5879','7.8009','9.699','83','78','84');
INSERT INTO provinces  VALUES ('Canada_OntarioEast','202,101','234,130','198,124',FALSE,'Ottawa','Taiga','Ontario','America North','>No Information Currently Available','990000','0.929','42080','0','-0.05','0','9197.1','401.2232','3690.089893','6.9675','7.7546','8.5648','81','78','83');
INSERT INTO provinces  VALUES ('Canada_QuebecSouthWest','202,101','234,130','233,104',FALSE,'Montreal','Taiga','Quebec','America North','>No Information Currently Available','1700000','0.929','42080','0','-0.05','0','15793','439.9232','6947.707098','7.9398','8.1944','9.2592','82','79','83');
INSERT INTO provinces  VALUES ('Canada_QuebecNorthWest','202,101','232,73','233,104',TRUE,'Quebec City','Tundra','Quebec','America North','>No Information Currently Available','530000','0.929','42080','0','-0.1','0','4923.7','405.0232','1994.21273','5.1851','7.8472','7.662','72','74','82');
INSERT INTO provinces  VALUES ('Canada_QuebecNorthEast','265,105','232,73','233,104',TRUE,'Kuujjuaq','Tundra','Quebec','America North','>No Information Currently Available','2700','0.929','42080','0','-0.1','0','25.083','407.0422','10.2098395','0.2314','7.8703','0.4629','56','74','56');
INSERT INTO provinces  VALUES ('Canada_NewBrunswick','234,130','249,120','233,104',TRUE,'Fredericton','Taiga','New Brunswick','America North','>No Information Currently Available','58000','0.929','42080','0','-0.05','0','538.82','437.1832','235.5630518','1.3657','8.1481','3.9583','57','79','62');
INSERT INTO provinces  VALUES ('Canada_NoviaScotiaNorth','265,105','249,120','233,104',TRUE,'Sydney','Taiga','Nova Scotia','America North','>No Information Currently Available','29000','0.929','42080','0','-0.05','0','269.41','414.0532','111.5500726','0.949','7.9861','2.3842','57','78','58');
INSERT INTO provinces  VALUES ('Canada_NoviaScotiaSouth','265,105','249,120','261,131',TRUE,'Halifax','Taiga','Nova Scotia','America North','>No Information Currently Available','430000','0.929','42080','0','-0.05','0','3994.7','408.0232','1629.930277','4.6296','7.8935','7.3611','66','78','82');
INSERT INTO provinces  VALUES ('America_PacificNorthwest','76,130','113,129','60,157',TRUE,'Seattle','Taiga','Washington','America West','>No Information Currently Available','600000','0.926','63051','0','-0.05','0','5556','591.85226','3288.331157','5.6018','9.2824','8.3101','75','79','83');
INSERT INTO provinces  VALUES ('America_RockiesWest','100,157','113,129','60,157',FALSE,'Portland','Plains','Oregon','America West','>No Information Currently Available','580000','0.926','63051','0','0','-0.2','5370.8','608.25226','3266.801238','5.5324','9.5138','8.2638','75','84','66');
INSERT INTO provinces  VALUES ('America_Rockies','100,157','113,129','128,175',FALSE,'Denver','Plains','Colorado','America West','>No Information Currently Available','600000','0.926','63051','0','0','-0.2','5556','591.85226','3288.331157','5.6018','9.2824','8.3101','75','83','66');
INSERT INTO provinces  VALUES ('America_WestSouthwest','60,157','100,157','77,192',FALSE,'Phoenix','Plains','Arizona','America West','(Grand Canyon)','3000000','0.926','63051','0.1','0','-0.2','27780','623.85226','17330.61578','8.6111','9.7222','9.8379','91','84','67');
INSERT INTO provinces  VALUES ('America_EastSouthwest','128,175','100,157','77,192',FALSE,'Albuquerque','Plains','New Mexico','America West','>No Information Currently Available','550000','0.926','63051','0','0','-0.2','5093','632.85226','3223.11656','5.2314','9.7916','8.1944','72','84','66');
INSERT INTO provinces  VALUES ('America_California','60,157','65,192','77,192',TRUE,'California','Savanna','California','America West','>No Information Currently Available','39000000','0.926','63051','0','0','0','361140','603.85226','218075.2052','10','9.4675','10','84','84','84');
INSERT INTO provinces  VALUES ('America_WestMidwest','113,129','128,175','147,145',FALSE,'Boise','Plains','Idaho','America West','>No Information Currently Available','220000','0.926','63051','0','0','-0.2','2037.2','603.45226','1229.352944','3.3564','9.4444','7.0138','60','83','65');
INSERT INTO provinces  VALUES ('America_NorthWestMidwest','113,129','132,128','147,145',FALSE,'Helena','Plains','Montana','America West','>No Information Currently Available','32000','0.926','63051','0','0','-0.2','296.32','627.61226','185.9740649','1.0416','9.7453','3.449','57','84','48');
INSERT INTO provinces  VALUES ('America_NorthMidwest','183,125','132,128','147,145',FALSE,'Minneapolis','Plains','Minnesota','America West','>No Information Currently Available','380000','0.926','63051','0','0','-0.2','3518.8','622.25226','2189.581252','4.3055','9.6759','7.8009','64','84','66');
INSERT INTO provinces  VALUES ('America_EastNorthMidwest','183,125','180,143','147,145',FALSE,'Milwaukee','Forest','Wisconsin','America East','>No Information Currently Available','590000','0.926','63051','0','0','0.1','5463.4','600.05226','3278.325517','5.5787','9.3981','8.287','75','83','91');
INSERT INTO provinces  VALUES ('America_SouthNorthMidwest','128,175','147,145','180,143',FALSE,'Chicago','Forest','Illinois','America East','>No Information Currently Available','2700000','0.926','63051','0','0','0.1','25002','619.85226','15497.5462','8.4259','9.6296','9.7916','83','84','92');
INSERT INTO provinces  VALUES ('America_TexasRegion','128,175','77,192','124,204',FALSE,'Austin','Savanna','Texas','America East','>No Information Currently Available','790000','0.926','63051','0','0','0','7315.4','586.05226','4287.206703','6.3888','9.1898','8.8425','79','83','83');
INSERT INTO provinces  VALUES ('America_WestMidatlantic','183,125','180,143','198,124',FALSE,'Detroit','Forest','Michigan','America East','>No Information Currently Available','710000','0.926','63051','0','0','0.1','6574.6','601.65226','3955.622949','6.0185','9.4212','8.7037','78','83','91');
INSERT INTO provinces  VALUES ('America_EastNorthMidatlantic','234,130','180,143','198,124',FALSE,'New York City','Forest','New York','America East','>No Information Currently Available','8100000','0.926','63051','0','0','0.1','75006','591.85226','44392.47061','9.5833','9.2824','9.9537','84','83','92');
INSERT INTO provinces  VALUES ('America_EastSouthMidatlantic','234,130','180,143','231,144',TRUE,'Philadelphia','Forest','Pennsylvania','America East','>No Information Currently Available','1500000','0.926','63051','0','0','0.1','13890','603.85226','8387.507891','7.5925','9.4675','9.4675','82','84','92');
INSERT INTO provinces  VALUES ('America_SouthCoast','128,175','161,198','124,204',TRUE,'Montgomery','Forest','Alabama','America East','>No Information Currently Available','200000','0.926','63051','0','0','0.1','6482','609.85226','3953.062349','5.9722','9.537','8.6805','78','84','91');
INSERT INTO provinces  VALUES ('America_Florida','167,216','161,198','173,188',TRUE,'Tallahassee','Forest','Florida','America East','>No Information Currently Available','180000','0.926','63051','0','0','0.1','1666.8','586.25226','977.165267','2.8703','9.2129','6.6203','59','83','88');
INSERT INTO provinces  VALUES ('America_EastInterior','128,175','161,198','180,143',FALSE,'Nashville','Forest','Tennessee','America East','>No Information Currently Available','690000','0.926','63051','0','0','0.1','6389.4','618.05226','3948.98311','5.9259','9.5833','8.6574','77','84','91');
INSERT INTO provinces  VALUES ('America_SouthEastInterior','173,188','161,198','180,143',FALSE,'Atlanta','Forest','Georgia','America East','>No Information Currently Available','420000','0.926','63051','0','0','0.1','3889.2','589.45226','2292.49773','4.537','9.2592','7.8472','66','83','91');
INSERT INTO provinces  VALUES ('America_NorthEastCoast','198,164','231,144','180,143',TRUE,'Richmond','Forest','Virginia','America East','>No Information Currently Available','200000','0.926','63051','0','0','0.1','1852','619.85226','1147.966386','3.0324','9.6296','6.9675','59','84','89');
INSERT INTO provinces  VALUES ('America_SouthEastCoast','198,164','173,188','180,143',TRUE,'Charlotte','Forest','North Carolina','America East','>No Information Currently Available','730000','0.926','63051','0','0','0.1','6759.8','585.25226','3956.188227','6.1342','9.1666','8.7268','78','83','91');
INSERT INTO provinces  VALUES ('Mexico_BajaCalifornia','79,225','65,192','77,192',TRUE,'Mexicali','Savanna','Baja California','America West','>No Information Currently Available','1000000','0.779','8069','0','0','0','7790','92.85751','723.3600029','6.5277','4.5601','5.9953','80','66','78');
INSERT INTO provinces  VALUES ('Mexico_NorthernMexico','77,192','124,204','104,223',FALSE,'Monterrey','Savanna','Nuevo Leon','America West','>No Information Currently Available','1100000','0.779','8069','0','0','0','8569','80.85751','692.8680032','6.7824','3.912','5.9027','81','62','77');
INSERT INTO provinces  VALUES ('Mexico_EastNorthernMexico','77,192','100,245','104,223',TRUE,'Guadalajara','Savanna','Jalisco','America West','>No Information Currently Available','1400000','0.779','8069','0','0','0','10906','94.85751','1034.516004','7.199','4.7222','6.8287','81','67','81');
INSERT INTO provinces  VALUES ('Mexico_WestNorthernMexico','122,243','124,204','104,223',TRUE,'Ciudad Victoria','Savanna','Tamaulipas','America East','>No Information Currently Available','300000','0.779','8069','0','0','0','2337','76.85751','179.6160009','3.6805','3.7962','3.3564','61','61','60');
INSERT INTO provinces  VALUES ('Mexico_Bajio','100,245','122,243','104,223',FALSE,'Mexico City','Desert','State of Mexico','America West','>No Information Currently Available','9200000','0.779','8069','0','0','0','71668','108.85751','7801.600027','9.5138','5.3703','9.4212','84','74','83');
INSERT INTO provinces  VALUES ('Mexico_PacificCoast','100,245','122,243','133,262',TRUE,'Chilpancingo','Desert','Guerrero','America West','>No Information Currently Available','180000','0.779','8069','0','0','0','1402.2','81.25751','113.9392805','2.5925','3.9583','2.4768','58','62','58');
INSERT INTO provinces  VALUES ('Mexico_Yucatan','145,230','122,243','133,262',TRUE,'Merida','Jungle','Yucatan','America East','(Chichen Itza as well as other mayan sites)','890000','0.779','8069','0.1','0','0.1','6933.1','76.05751','527.3143226','6.2268','3.75','5.4166','87','61','81');
INSERT INTO provinces  VALUES ('Mexico_Chiapas','139,248','155,255','133,262',TRUE,'Tuxtla Gutierrez','Jungle','Chiapas','Mexico','>No Information Currently Available','600000','0.779','8069','0','0','0.1','4674','90.85751','424.6680017','5','4.3518','4.9305','70','64','76');
INSERT INTO provinces  VALUES ('CentralAmerica_CentralAmerica','155,255','161,283','133,262',TRUE,'Managua','Jungle','Nicaragua','Mexico','>No Information Currently Available','1000000','0.66','1832','0','0','0.1','6600','12.0912','79.80192','6.0416','0.3009','1.9444','78','56','63');
INSERT INTO provinces  VALUES ('CentralAmerica_Panama','176,276','161,283','171,290',TRUE,'Panama City','Jungle','Panama','Mexico','>No Information Currently Available','860000','0.815','14090','0','0','0.1','7009','116.8335','818.8860015','6.2731','5.8101','6.2731','79','77','87');
INSERT INTO provinces  VALUES ('CemtralAmerica_Cuba','157,225','181,238','185,234',TRUE,'Havana','Jungle','Cuba','America East','>No Information Currently Available','2100000','0.783','8822','0','0','0.1','16443','108.07626','1777.097943','8.0092','5.3472','7.5','82','73','90');
INSERT INTO provinces  VALUES ('CemtralAmerica_Dominican','190,245','193,236','201,244',TRUE,'Santo Domingo','Jungle','Dominican Republic','America East','>No Information Currently Available','960000','0.756','7445','0','0','0.1','7257.6','103.0842','748.1438899','6.3657','5.0925','6.0185','79','71','86');
INSERT INTO provinces  VALUES ('SouthAmerica_NorthColumbia','176,276','195,296','171,290',FALSE,'Medellin','Jungle','Colombia','South America West','>No Information Currently Available','2500000','0.767','5207','0','0','0.1','19175','39.93769','765.8052058','8.2175','1.9907','6.1342','83','58','86');
INSERT INTO provinces  VALUES ('SouthAmerica_SouthColumbia','167,305','195,296','171,290',TRUE,'Bogota','Jungle','Colombia','South America West','>No Information Currently Available','7400000','0.767','5207','0','0','0.1','56758','49.93769','2834.363409','9.2361','2.6388','8.1481','83','58','91');
INSERT INTO provinces  VALUES ('SouthAmerica_NorthVenezuela','176,276','190,266','208,276',TRUE,'Maracaibo','Plains','Venezuela','South America East','>No Information Currently Available','200000','0.711','1739','0','0','-0.2','1422','32.36429','46.02202038','2.662','1.4351','1.5046','58','57','46');
INSERT INTO provinces  VALUES ('SouthAmerica_SouthVenezuela','176,276','195,296','208,276',FALSE,'Caracas','Jungle','Venezuela','South America East','>No Information Currently Available','2200000','0.711','1739','0','0','0.1','15642','32.36429','506.2422242','7.8935','1.4351','5.324','82','57','80');
INSERT INTO provinces  VALUES ('SouthAmerica_EastVenezuela','228,284','195,296','208,276',TRUE,'Ciudad Guayana','Jungle','Venezuela','South America East','>No Information Currently Available','700000','0.711','1739','0','0','0.1','4977','32.36429','161.0770713','5.2083','1.4351','3.0092','72','57','65');
INSERT INTO provinces  VALUES ('SouthAmerica_Guiana','228,284','195,296','250,299',TRUE,'Cayenne','Jungle','Guiana','South America East','>No Information Currently Available','60000','0.682','8073','0','0','0.1','409.2','61.85786','25.31223631','1.1342','3.1018','1.0648','57','59','62');
INSERT INTO provinces  VALUES ('SouthAmerica_Amazonas','204,325','195,296','250,299',FALSE,'Manaus','Jungle','Amazonas','South America East','>No Information Currently Available','2000000','0.765','6450','0','0','0.1','15300','49.3425','754.94025','7.8703','2.3842','6.0648','82','58','86');
INSERT INTO provinces  VALUES ('SouthAmerica_Ecuador','167,305','195,296','160,329',TRUE,'Quito','Jungle','Ecuador','South America West','>No Information Currently Available','2000000','0.759','5845','0','0','0.1','15180','64.36355','977.038689','7.8009','3.2638','6.574','82','60','88');
INSERT INTO provinces  VALUES ('SouthAmerica_NorthPeru','204,325','195,296','160,329',FALSE,'Chiclayo','Jungle','North Peru','South America West','>No Information Currently Available','550000','0.777','5845','0','0','0.1','4273.5','87.41565','373.5707803','4.7222','4.1666','4.5601','67','63','72');
INSERT INTO provinces  VALUES ('SouthAmerica_CentralPeru','204,325','185,378','160,329',TRUE,'Lima','Jungle','Central Peru','South America West','>No Information Currently Available','9500000','0.777','5845','0','0','0.1','73815','75.41565','5566.806205','9.5601','3.6805','9.0277','84','61','92');
INSERT INTO provinces  VALUES ('SouthAmerica_SouthPeru','204,325','185,378','208,374',FALSE,'Cusco','Jungle','South Peru','South America West','(Holy site - Cusco, sun temple)','420000','0.777','5845','0.2','0','0.1','3263.4','80.21565','261.7757522','4.2592','3.8425','4.1435','76','61','69');
INSERT INTO provinces  VALUES ('SouthAmerica_Bolivia','236,355','235,397','208,374',FALSE,'Sucre','Savanna','Bolivia','South America West','>No Information Currently Available','300000','0.718','3322','0','0','0','2154','67.85196','146.1531218','3.4722','3.3564','2.8472','60','60','59');
INSERT INTO provinces  VALUES ('SouthAmerica_WestBrazil','236,355','204,325','208,374',FALSE,'Porto Velho','Jungle','Rondonia','South America East','>No Information Currently Available','500000','0.765','6450','0','0','0.1','3825','49.3425','188.7350625','4.4907','2.3842','3.5185','65','58','66');
INSERT INTO provinces  VALUES ('SouthAmerica_NorthBrazil','250,299','204,325','289,311',TRUE,'Sao Luis','Jungle','Maranhao','South America East','>No Information Currently Available','1100000','0.765','6450','0','0','0.1','8415','49.3425','415.2171375','6.7129','2.3842','4.8611','80','58','75');
INSERT INTO provinces  VALUES ('SouthAmerica_WestCentralBrazil','236,355','204,325','289,311',FALSE,'Cuiaba','Jungle','Mato grosso','South America East','>No Information Currently Available','600000','0.765','6450','0','0','0.1','4590','49.3425','226.482075','4.9768','2.3842','3.8888','70','58','68');
INSERT INTO provinces  VALUES ('SouthAmerica_CentralBrazil','236,355','299,365','289,311',FALSE,'Palmas','Jungle','Tocantins','South America East','>No Information Currently Available','300000','0.765','6450','0','0','0.1','2295','49.3425','113.2410375','3.6342','2.3842','2.4537','61','58','64');
INSERT INTO provinces  VALUES ('SouthAmerica_EastCentralBrazil','306,342','299,365','289,311',TRUE,'Natal','Jungle','Rio Grande do Norte','South America East','>No Information Currently Available','890000','0.765','6450','0','0','0.1','6808.5','94.3425','642.3309113','6.1805','4.699','5.8101','79','67','84');
INSERT INTO provinces  VALUES ('SouthAmerica_SouthCentralBrazil','236,355','299,365','256,376',FALSE,'Goiania','Jungle','Goias','South America East','>No Information Currently Available','1500000','0.765','6450','0','0','0.1','11475','49.3425','566.2051875','7.2916','2.3842','5.6481','82','58','83');
INSERT INTO provinces  VALUES ('SouthAmerica_SouthBrazil','280,403','299,365','256,376',TRUE,'Rio de Janeiro','Jungle','Rio de Janeiro','South America East','(Christ the redeemer)','6700000','0.765','6450','0.2','0','0.1','51255','49.3425','2529.049838','9.1203','2.3842','7.9166','100','58','91');
INSERT INTO provinces  VALUES ('SouthAmerica_Paraguay','236,355','235,397','256,376',FALSE,'Concepcion','Jungle','Paraguay','South America East','>No Information Currently Available','76000','0.728','4909','0','0','0.1','553.28','36.37752','20.12695427','1.3888','1.7592','0.9027','57','57','62');
INSERT INTO provinces  VALUES ('SouthAmerica_SouthParaguay','235,397','280,403','256,376',FALSE,'Asuncion','Jungle','Paraguay','South America East','>No Information Currently Available','520000','0.728','4909','0','0','0.1','3785.6','58.53752','221.5996357','4.4675','2.9629','3.8657','65','59','68');
INSERT INTO provinces  VALUES ('SouthAmerica_Uruguay','280,403','235,397','262,420',TRUE,'Montevideo','Plains','Uruguay','South America East','>No Information Currently Available','1300000','0.817','15332','0','0','-0.2','10621','163.26244','1734.010375','7.1527','6.4583','7.4537','81','80','65');
INSERT INTO provinces  VALUES ('SouthAmerica_Andean','200,446','235,397','197,408',TRUE,'Calama','Plains','Chile','South America West','>No Information Currently Available','70000','0.718','3322','0','0','-0.2','502.6','62.45196','31.3883551','1.2962','3.1481','1.25','57','59','46');
INSERT INTO provinces  VALUES ('SouthAmerica_NorthChile','185,378','208,374','197,408',TRUE,'Iquique','Plains','Chile','South America West','>No Information Currently Available','190000','0.851','12612','0','0','-0.2','1616.9','130.02812','210.2424672','2.8472','6.3425','3.7037','59','79','49');
INSERT INTO provinces  VALUES ('SouthAmerica_NorthArgentina','235,397','208,374','197,408',FALSE,'Cordoba','Plains','Argentina','South America West','>No Information Currently Available','1300000','0.845','8433','0','0','-0.2','10985','91.25885','1002.478467','7.2453','4.375','6.7129','82','64','64');
INSERT INTO provinces  VALUES ('SouthAmerica_NorthCentralArgentina','200,446','262,420','235,397',FALSE,'Buenos Aires','Plains','Argentina','South America East','>No Information Currently Available','15000000','0.845','8433','0','0','-0.2','126750','71.25885','9032.059238','9.9305','3.5185','9.5138','84','60','67');
INSERT INTO provinces  VALUES ('SouthAmerica_SouthCentralArgentina','200,446','262,420','247,460',TRUE,'Bahia Blanca','Plains','Argentina','South America East','>No Information Currently Available','300000','0.845','8433','0','0','-0.2','2535','91.25885','231.3411848','3.8194','4.375','3.9351','61','64','49');
INSERT INTO provinces  VALUES ('SouthAmerica_SouthArgentina','200,446','220,486','247,460',FALSE,'Neuquen','Plains','Argentina','South America East','>No Information Currently Available','220000','0.845','8433','0','0','-0.2','1859','109.25885','203.1122022','3.0555','5.3935','3.6342','59','74','48');
INSERT INTO provinces  VALUES ('SouthAmerica_SouthChile','200,446','220,486','214,511',TRUE,'Santiago','Forest','Chile','South America West','>No Information Currently Available','5200000','0.851','12612','0','0','0.1','44252','123.32812','5457.515966','9.0046','6.1111','9.0046','83','78','92');
INSERT INTO provinces  VALUES ('SouthAmerica_Chubut','247,460','220,486','232,510',TRUE,'rio Gallegos','Plains','Argentina','South America East','>No Information Currently Available','97000','0.845','8433','0','0','-0.2','819.65','102.55885','84.0623614','1.8518','5.0694','2.0138','57','71','46');
INSERT INTO provinces  VALUES ('SouthAmerica_SantaCruz','214,511','232,510','220,486',FALSE,'Punta Arenas','Forest','Magellan','South America East','>No Information Currently Available','120000','0.845','8433','0','0','0.1','1014','119.25885','120.9284739','2.2453','5.9027','2.5925','58','77','64');
INSERT INTO provinces  VALUES ('SouthAmerica_Magallanes','214,511','232,510','238,528',TRUE,'Tolhuin','Forest','Magellan','South America East','>No Information Currently Available','2900','0.845','8433','0','0','0.1','24.505','79.66885','1.952285169','0.2083','3.8194','0.1157','56','61','62');
INSERT INTO provinces  VALUES ('Greenland_Kujalleq','305,83','299,50','330,59',TRUE,'Nanortalik','Tundra','Kujalleq','North Atlantic','>No Information Currently Available','1100','0.949','53353','0','-0.1','0','10.439','510.22497','5.326238462','0.1157','8.8657','0.3472','56','75','56');
INSERT INTO provinces  VALUES ('Greenland_Qeqqata','305,83','299,50','289,68',TRUE,'Sisimiut','Tundra','Qeqqata','North Atlantic','>No Information Currently Available','5500','0.949','53353','0','-0.1','0','52.195','525.84497','27.44647821','0.3935','9.074','1.1342','56','75','57');
INSERT INTO provinces  VALUES ('Greenland_SouthSermersooq','331,23','299,50','330,59',FALSE,'Nuuk','Tundra','Sermersooq','North Atlantic','>No Information Currently Available','18000','0.949','53353','0','-0.1','0','170.82','520.21997','88.86397528','0.7175','8.9583','2.1296','57','75','58');
INSERT INTO provinces  VALUES ('Greenland_Sermersooq','331,23','379,27','330,59',TRUE,'Atammik','Tundra','Sermersooq','North Atlantic','>No Information Currently Available','190','0.949','53353','0','-0.1','0','1.8031','506.99447','0.914161729','0.0231','8.7268','0.0231','56','75','56');
INSERT INTO provinces  VALUES ('Greenland_SouthQaasuitsup','331,23','299,50','281,26',TRUE,'Ilulissat','Tundra','Qaasuitsup','North Atlantic','>No Information Currently Available','4600','0.949','53353','0','-0.1','0','43.654','522.64997','22.81576179','0.3703','9.0277','0.949','56','75','57');
INSERT INTO provinces  VALUES ('Greenland_NorthQaasuitsup','331,23','331,7','281,26',TRUE,'Kullorsuaq','Tundra','Qaasuitsup','North Atlantic','>No Information Currently Available','450','0.949','53353','0','-0.1','0','4.2705','507.91747','2.169061556','0.0694','8.75','0.162','56','75','56');
INSERT INTO provinces  VALUES ('Greenland_NorthEastGreenland','331,23','331,7','379,26',TRUE,'Nuussuaq','Tundra','North East Greenland','North Atlantic','>No Information Currently Available','180','0.949','53353','0','-0.1','0','1.7082','506.95897','0.865987313','0','8.7037','0','56','75','56');
INSERT INTO provinces  VALUES ('Greenland_Iceland','359,62','371,72','379,61',TRUE,'Reykjavik','Tundra','Iceland','North Atlantic','>No Information Currently Available','130000','0.949','57189','0','-0.1','0','1233.7','554.22361','683.7456677','2.3842','9.1435','5.8564','58','75','77');
INSERT INTO provinces  VALUES ('Britain_IrelandNorth','395,101','385,104','394,110',TRUE,'Belfast','Forest','Ireland','North Atlantic','>No Information Currently Available','280000','0.932','39229','0','0','0.1','2609.6','388.41428','1013.605905','3.8888','7.5694','6.7824','62','82','89');
INSERT INTO provinces  VALUES ('Britain_IrelandSouth','385,114','385,104','394,110',TRUE,'Dublin','Forest','Ireland','North Atlantic','>No Information Currently Available','550000','0.955','79669','0','0','0.1','5252.5','800.83895','4206.406585','5.4166','9.9768','8.7962','74','84','91');
INSERT INTO provinces  VALUES ('Britain_Scotland','396,95','401,88','406,97',TRUE,'Edinburgh','Forest','Scotland','North Atlantic','>No Information Currently Available','480000','0.932','39229','0','0','0.1','4473.6','390.41428','1746.557323','4.8842','7.5925','7.4768','69','82','90');
INSERT INTO provinces  VALUES ('Britain_Northumberland','396,95','406,97','404,106',TRUE,'Lancaster','Forest','England','North Atlantic','>No Information Currently Available','144000','0.932','39229','0','0','0.1','1342.08','413.05428','554.3518881','2.5231','7.9398','5.5787','58','82','83');
INSERT INTO provinces  VALUES ('Britain_Yorkshire','411,106','406,97','404,106',TRUE,'York','Forest','England','North Atlantic','>No Information Currently Available','210000','0.932','39229','0','0','0.1','1957.2','395.21428','773.5133888','3.287','7.6388','6.1574','60','82','86');
INSERT INTO provinces  VALUES ('Britain_SouthEnglandAndWales','411,106','397,114','404,106',TRUE,'London','Forest','England','North Atlantic','>No Information Currently Available','8900000','0.932','39229','0','0','0.1','82948','379.61428','31488.2453','9.699','7.4768','9.9305','84','82','92');
INSERT INTO provinces  VALUES ('Europe_FranceBritanny','397,125','409,122','406,132',TRUE,'Rennes','Forest','Bretange','Europe','>No Information Currently Available','210000','0.901','39257','0','0','0.1','1892.1','372.70557','705.196209','3.125','7.3842','5.9259','59','82','85');
INSERT INTO provinces  VALUES ('Europe_FrancePaysDeLaLoire','422,132','409,122','406,132',FALSE,'Nantes','Forest','Pays De La Loire','Europe','>No Information Currently Available','300000','0.901','39257','0','0','0.1','2703','373.70557','1010.126156','3.9583','7.4074','6.7361','62','82','89');
INSERT INTO provinces  VALUES ('Europe_FranceNormandy','422,132','409,122','421,114',TRUE,'Rouen','Forest','Normandy','Europe','>No Information Currently Available','110000','0.901','39257','0','0','0.1','991.1','382.70557','379.2994904','2.1759','7.5','4.6296','58','82','73');
INSERT INTO provinces  VALUES ('Europe_FranceAquitane','422,132','406,132','407,145',TRUE,'Bordeaux','Forest','Aquitaine','Europe','>No Information Currently Available','250000','0.901','39257','0','0','0.1','2252.5','378.70557','853.0342964','3.5879','7.4305','6.3888','60','82','87');
INSERT INTO provinces  VALUES ('Europe_FranceOccitanie','422,132','425,146','407,145',FALSE,'Toulouse','Forest','Occitanie','Europe','>No Information Currently Available','470000','0.901','39257','0','0','0.1','4234.7','386.70557','1637.582077','4.699','7.5231','7.3842','67','82','90');
INSERT INTO provinces  VALUES ('Europe_FranceAlpes','422,132','425,146','435,141',TRUE,'Marseille','Forest','Alpes','Europe','>No Information Currently Available','860000','0.901','39257','0','0','0.1','7748.6','357.70557','2771.71738','6.4814','7.2685','8.1018','80','82','91');
INSERT INTO provinces  VALUES ('Europe_FranceStrasbourg','422,132','434,128','421,114',FALSE,'Strasbourg','Forest','Grand Est','Europe','>No Information Currently Available','280000','0.901','39257','0','0','0.1','2522.8','395.70557','998.286012','3.7962','7.662','6.6898','61','82','88');
INSERT INTO provinces  VALUES ('Europe_Switzerland','422,132','434,128','435,141',FALSE,'Bern','Forest','Switzerland','Europe','>No Information Currently Available','130000','0.955','81867','0','0','0.1','1241.5','815.82985','1012.852759','2.4074','10','6.7592','58','84','89');
INSERT INTO provinces  VALUES ('Europe_DutchRegions','421,114','434,128','432,105',TRUE,'Amsterdam','Forest','Netherlands','Europe','>No Information Currently Available','870000','0.944','51290','0','0','0.1','8212.8','490.1776','4025.730593','6.6203','8.449','8.75','80','83','91');
INSERT INTO provinces  VALUES ('Europe_ItalyMilan','445,139','434,128','435,141',FALSE,'Milan','Forest','Lombardy','Europe','>No Information Currently Available','1300000','0.892','30657','0','0','0.1','11596','321.46044','3727.655262','7.3379','7.2453','8.6111','82','82','91');
INSERT INTO provinces  VALUES ('Europe_ItalyTuscany','445,139','444,152','435,141',TRUE,'Florence','Savanna','Tuscany','Europe','>No Information Currently Available','380000','0.892','30657','0','0','0','3389.6','288.26044','977.0875874','4.2824','7.1064','6.5972','64','81','80');
INSERT INTO provinces  VALUES ('Europe_ItalyNaples','445,139','444,152','456,158',TRUE,'Rome','Savanna','Lazio','Europe','(Holy site - Vatican city)','4300000','0.892','30657','0.4','0','0','38356','301.46044','11562.81664','8.8888','7.1527','9.7222','116','81','84');
INSERT INTO provinces  VALUES ('Europe_ItalySicily','443,166','452,172','456,158',TRUE,'Palermo','Savanna','Sicily','Europe','>No Information Currently Available','670000','0.892','30657','0','0','0','5976.4','316.66044','1892.489454','5.8101','7.199','7.5462','77','81','82');
INSERT INTO provinces  VALUES ('Europe_SpainCatalonia','407,145','425,146','408,161',TRUE,'Barcelona','Savanna','Catalonia','Europe','>No Information Currently Available','1600000','0.904','26832','0','0','0','14464','252.56128','3653.046354','7.6388','6.9444','8.5416','82','81','83');
INSERT INTO provinces  VALUES ('Europe_SpainValencia','401,172','408,161','397,162',TRUE,'Valencia','Savanna','Valencia','Europe','>No Information Currently Available','800000','0.904','26832','0','0','0','7232','272.56128','1971.163177','6.3425','7.0138','7.6157','79','81','82');
INSERT INTO provinces  VALUES ('Europe_SpainLaMancha','408,161','394,153','397,162',FALSE,'Toledo','Savanna','La Mancha','Europe','>No Information Currently Available','80000','0.904','26832','0','0','0','723.2','290.56128','210.1339177','1.7361','7.1296','3.6805','57','81','61');
INSERT INTO provinces  VALUES ('Europe_SpainBurgos','407,145','394,153','408,161',FALSE,'Burgos','Savanna','Burgos','Europe','>No Information Currently Available','170000','0.904','26832','0','0','0','1536.8','244.56128','375.8417751','2.7777','6.9212','4.5833','59','81','66');
INSERT INTO provinces  VALUES ('Europe_SpainLeon','407,145','394,153','394,145',TRUE,'Leon','Savanna','Leon','Europe','>No Information Currently Available','120000','0.904','26832','0','0','0','1084.8','264.56128','286.9960765','2.2685','6.9907','4.2361','58','81','63');
INSERT INTO provinces  VALUES ('Europe_SpainGalicia','384,145','394,153','394,145',TRUE,'La Coruna','Savanna','Galicia','Europe','>No Information Currently Available','240000','0.904','26832','0','0','0','2169.6','286.56128','621.7233531','3.5185','7.0833','5.7638','60','81','77');
INSERT INTO provinces  VALUES ('Europe_SpainExtremadura','384,165','394,153','397,162',FALSE,'Badajoz','Savanna','Extremadura','Europe','>No Information Currently Available','150000','0.904','26832','0','0','0','1356','282.56128','383.1530957','2.5462','7.037','4.6527','58','81','67');
INSERT INTO provinces  VALUES ('Europe_SpainNorthAndalusia','397,162','384,165','401,172',FALSE,'Cordoba','Savanna','Andalusia','Europe','>No Information Currently Available','320000','0.904','26832','0','0','0','2892.8','284.56128','823.1788708','4.074','7.0601','6.2962','63','81','79');
INSERT INTO provinces  VALUES ('Europe_SpainSouthAndalusia','389,173','384,165','401,172',TRUE,'Cadiz','Savanna','Andalusia','Europe','>No Information Currently Available','110000','0.904','26832','0','0','0','994.4','258.56128','257.1133368','2.199','6.9675','4.074','58','81','63');
INSERT INTO provinces  VALUES ('Europe_Portugal','384,165','394,153','385,145',TRUE,'Lisbon','Savanna','Portugal','Europe','>No Information Currently Available','500000','0.864','21608','0','0','0','4320','186.69312','806.5142784','4.7453','6.6898','6.25','68','80','79');
INSERT INTO provinces  VALUES ('Europe_GermanyBavaria','434,128','445,139','449,118',FALSE,'Munich','Forest','Bavaria','Europe','>No Information Currently Available','1400000','0.947','45466','0','0','0.1','13258','440.56302','5840.984519','7.5694','8.2407','9.0972','82','83','92');
INSERT INTO provinces  VALUES ('Europe_GermanySaxony','434,128','432,105','449,118',FALSE,'Dresden','Forest','Saxony','Europe','>No Information Currently Available','550000','0.947','45466','0','0','0.1','5208.5','438.06302','2281.65124','5.3472','8.1712','7.824','73','83','91');
INSERT INTO provinces  VALUES ('Europe_GermanyBrandenberg','447,105','432,105','449,118',TRUE,'Berlin','Forest','Brandenberg','Europe','>No Information Currently Available','3600000','0.947','45466','0','0','0.1','34092','470.56302','16042.43448','8.7731','8.3564','9.8148','83','83','92');
INSERT INTO provinces  VALUES ('Europe_GermanySchleswig','447,105','432,100','432,105',TRUE,'Kiel','Forest','Schleswig','Europe','>No Information Currently Available','240000','0.947','45466','0','0','0.1','2272.8','436.56302','992.2204319','3.6111','8.1018','6.6666','61','83','88');
INSERT INTO provinces  VALUES ('Europe_GermanyPomerania','449,118','447,105','463,102',TRUE,'Schwerin','Forest','Pomerania','Europe','>No Information Currently Available','95000','0.947','45466','0','0','0.1','899.65','467.31302','420.4181584','2.0833','8.3333','4.8842','58','83','76');
INSERT INTO provinces  VALUES ('Europe_PolandSilesia','449,118','463,123','462,103',FALSE,'Warsaw','Forest','Poland','Europe','>No Information Currently Available','1700000','0.88','15304','0','0','0.1','14960','154.6752','2313.940992','7.7777','6.4351','7.8703','82','80','91');
INSERT INTO provinces  VALUES ('Europe_CzechRepublic','449,118','463,123','457,131',FALSE,'Prague','Forest','Czechia','Europe','>No Information Currently Available','1300000','0.9','22627','0','0','0.1','11700','203.643','2382.6231','7.3611','6.8055','7.8935','82','81','91');
INSERT INTO provinces  VALUES ('Europe_Austria','449,118','445,139','457,131',FALSE,'Vienna','Forest','Austria','Europe','>No Information Currently Available','1800000','0.922','48634','0','0','0.1','16596','480.40548','7972.809346','8.0555','8.4027','9.4444','83','83','92');
INSERT INTO provinces  VALUES ('Europe_Croatia','457,145','445,139','457,131',TRUE,'Zagreb','Forest','Croatia','Europe','>No Information Currently Available','790000','0.854','14033','0','0','0.1','6746.6','167.64182','1131.012303','6.1111','6.5046','6.9444','78','80','89');
INSERT INTO provinces  VALUES ('Europe_Hungary','457,131','463,123','470,135',FALSE,'Budapest','Forest','Hungary','Europe','>No Information Currently Available','1700000','0.851','15373','0','0','0.1','14467','141.82423','2051.771135','7.662','6.412','7.6851','82','80','90');
INSERT INTO provinces  VALUES ('Europe_Bosnia','457,131','457,145','470,135',FALSE,'Sarajevo','Forest','Bosnia','Europe','>No Information Currently Available','270000','0.854','5762','0','0','0.1','2305.8','70.60748','162.8067274','3.6574','3.4953','3.0324','61','60','65');
INSERT INTO provinces  VALUES ('Europe_Albania','464,155','457,145','470,135',TRUE,'Tirana','Savanna','Albania','Europe','>No Information Currently Available','550000','0.795','4898','0','0','0','4372.5','76.4391','334.2299648','4.7685','3.7731','4.4212','68','61','65');
INSERT INTO provinces  VALUES ('Europe_Serbia','470,135','477,144','464,155',FALSE,'Belgrade','Savanna','Serbia','Europe','>No Information Currently Available','1100000','0.806','8506','0','0','0','8866','84.55836','749.6944198','6.8518','4.074','6.0416','81','63','78');
INSERT INTO provinces  VALUES ('Europe_Bulgaria','470,135','477,144','491,140',FALSE,'Sofia','Savanna','Bulgaria','Europe','>No Information Currently Available','1200000','0.816','9826','0','0','0','9792','106.18016','1039.716127','7.037','5.3009','6.875','81','73','81');
INSERT INTO provinces  VALUES ('Europe_Romania','470,135','463,123','494,121',FALSE,'Bucharest','Forest','Romania','Europe','>No Information Currently Available','1800000','0.828','12813','0','0','0.1','14904','126.09164','1879.269803','7.7546','6.2268','7.5231','82','79','90');
INSERT INTO provinces  VALUES ('Europe_UkraineWest','470,135','494,121','491,140',FALSE,'Ternopil','Forest','West Ukraine','Europe','>No Information Currently Available','220000','0.779','3425','0','0','0.1','1713.8','60.28075','103.3091494','2.9166','3.0555','2.3148','59','59','64');
INSERT INTO provinces  VALUES ('Europe_UkraineCenter','505,136','494,121','491,140',TRUE,'Kyiv','Forest','Central Ukraine','Europe','>No Information Currently Available','2800000','0.779','3425','0','0','0.1','21812','40.68075','887.328519','8.3564','2.037','6.4583','83','58','88');
INSERT INTO provinces  VALUES ('Europe_UkraineEast','505,136','494,121','518,121',FALSE,'Dnipro','Forest','Eastern Ukraine','Europe','>No Information Currently Available','960000','0.779','3425','0','0','0.1','7478.4','41.48075','310.2096408','6.4351','2.1296','4.3518','80','58','71');
INSERT INTO provinces  VALUES ('Europe_GreeceMacedonia','485,155','477,144','464,155',FALSE,'Skopje','Savanna','Macedonia','Europe','>No Information Currently Available','500000','0.888','18168','0','0','0','4440','181.33184','805.1133696','4.8379','6.6203','6.2268','68','80','79');
INSERT INTO provinces  VALUES ('Europe_GreecePeloponnese','485,155','464,155','472,171',TRUE,'Patras','Savanna','Peloponnese','Europe','>No Information Currently Available','160000','0.888','18168','0','0','0','1420.8','181.73184','258.2045983','2.6388','6.6435','4.0972','58','80','63');
INSERT INTO provinces  VALUES ('Europe_BelarusSouth','463,123','462,103','494,121',FALSE,'Brest','Forest','Belarus','Europe','>No Information Currently Available','350000','0.823','6134','0','0','0.1','2880.5','59.98282','172.780513','4.0509','3.0092','3.2407','62','59','65');
INSERT INTO provinces  VALUES ('Europe_BelarusNorth','478,101','462,103','494,121',FALSE,'Minsk','Forest','Belarus','Europe','>No Information Currently Available','2000000','0.823','6134','0','0','0.1','16460','90.48282','1489.347217','8.0324','4.3055','7.2453','83','64','90');
INSERT INTO provinces  VALUES ('Europe_BalticStates','478,101','462,103','470,89',TRUE,'Vilnius','Forest','Baltic States','Europe','>No Information Currently Available','580000','0.892','19883','0','0','0.1','5173.6','184.15636','952.7513441','5.2777','6.6666','6.5509','73','80','88');
INSERT INTO provinces  VALUES ('Scandinavia_Denmark','435,92','432,100','436,100',TRUE,'Copenhagen','Forest','Denmark','North Atlantic','>No Information Currently Available','790000','0.94','58439','0','0','0.1','7426','593.3266','4406.043332','6.412','9.3518','8.8888','80','83','92');
INSERT INTO provinces  VALUES ('Scandinavia_SwedenSkane','440,100','444,95','448,98',TRUE,'Malmo','Forest','Skane','North Atlantic','>No Information Currently Available','340000','0.945','50339','0','0','0.1','3213','510.70355','1640.890506','4.1898','8.8888','7.4074','63','83','90');
INSERT INTO provinces  VALUES ('Scandinavia_SwedenSmaland','453,89','444,95','448,98',TRUE,'Jonkoping','Forest','Smaland','North Atlantic','>No Information Currently Available','93000','0.945','50339','0','0','0.1','878.85','496.45355','436.3082024','2.0601','8.5648','4.9768','58','83','77');
INSERT INTO provinces  VALUES ('Scandinavia_SwedenUppland','453,89','453,79','459,84',TRUE,'Stockholm','Forest','Uppland','North Atlantic','>No Information Currently Available','970000','0.945','50339','0','0','0.1','9166.5','493.20355','4520.950341','6.9444','8.4722','8.912','81','83','92');
INSERT INTO provinces  VALUES ('Scandinavia_SwedenVastergotland','453,89','453,79','438,87',FALSE,'Gothenburg','Forest','Vastergotland','North Atlantic','>No Information Currently Available','570000','0.945','50339','0','0','0.1','5386.5','493.20355','2656.640922','5.5555','8.4722','7.9629','75','83','91');
INSERT INTO provinces  VALUES ('Scandinavia_SwedenHalland','453,89','444,95','438,87',TRUE,'Halmstad','Forest','Halland','North Atlantic','>No Information Currently Available','70000','0.945','50339','0','0','0.1','661.5','518.20355','342.7916483','1.6435','8.9351','4.4907','57','83','72');
INSERT INTO provinces  VALUES ('Scandinavia_SwedenVarmland','438,87','453,79','441,73',FALSE,'Karlstad','Forest','Varmland','North Atlantic','>No Information Currently Available','61000','0.945','50339','0','0','0.1','576.45','498.45355','287.3335489','1.4351','8.5879','4.2592','57','83','70');
INSERT INTO provinces  VALUES ('Scandinavia_SwedenVasterbotten','462,64','453,79','441,73',TRUE,'Umea','Taiga','Vasterbotten','North Atlantic','>No Information Currently Available','90000','0.945','50339','0','-0.05','0','850.5','523.20355','444.9846193','1.9675','9.0509','5.0462','57','79','70');
INSERT INTO provinces  VALUES ('Scandinavia_SwedenLappland','462,64','453,53','441,73',FALSE,'Kiruna','Taiga','Swedish Lappland','North Atlantic','[Some Sami people prefer the name Sapmi]','18000','0.945','50339','0','-0.05','0','170.1','515.20355','87.63612386','0.6944','8.912','2.0833','57','79','58');
INSERT INTO provinces  VALUES ('Scandinavia_NorwayNordland','429,73','453,53','441,73',TRUE,'Bodo','Taiga','Nordland','North Atlantic','>No Information Currently Available','55000','0.957','67989','0','-0.05','0','526.35','660.25473','347.5250771','1.3194','9.8611','4.5138','57','79','65');
INSERT INTO provinces  VALUES ('Scandinavia_NorwayTrondelag','429,73','432,80','441,73',FALSE,'Trondheim','Taiga','Trondelag','North Atlantic','>No Information Currently Available','200000','0.957','67989','0','-0.05','0','1914','694.65473','1329.569153','3.1712','9.9305','7.0833','59','80','81');
INSERT INTO provinces  VALUES ('Scandinavia_NorwayNorthWestern','429,73','432,80','422,82',TRUE,'Molde','Forest','More og Romsdal','North Atlantic','>No Information Currently Available','21000','0.957','67989','0','0','0.1','200.97','699.77473','140.6337275','0.8101','9.9537','2.7546','57','84','64');
INSERT INTO provinces  VALUES ('Scandinavia_NorwaySouthWestern','429,89','432,80','422,82',TRUE,'Stavanger','Forest','Rogaland','North Atlantic','>No Information Currently Available','130000','0.957','67989','0','0','0.1','1244.1','664.25473','826.3993096','2.4305','9.8842','6.3425','58','84','87');
INSERT INTO provinces  VALUES ('Scandinavia_NorwayNorthEastern','438,87','432,80','441,73',FALSE,'Hamar','Forest','Innlandet','North Atlantic','>No Information Currently Available','30000','0.957','67989','0','0','0.1','287.1','692.25473','198.746333','1.0185','9.9074','3.5648','57','84','66');
INSERT INTO provinces  VALUES ('Scandinavia_NorwaySouthEastern','438,87','432,80','429,89',TRUE,'Oslo','Forest','Oslo','North Atlantic','>No Information Currently Available','690000','0.957','67989','0','0','0.1','6603.3','657.45473','4341.370819','6.0648','9.8379','8.8657','78','84','91');
INSERT INTO provinces  VALUES ('Scandinavia_NorwayFinnmark','453,53','462,64','473,45',TRUE,'Tromso','Tundra','Finnmark','North Atlantic','>No Information Currently Available','64000','0.957','67989','0','-0.1','0','612.48','652.73473','399.7869674','1.5046','9.8148','4.7453','57','75','68');
INSERT INTO provinces  VALUES ('Scandinavia_FinlandFinnishLapland','477,65','462,64','473,45',TRUE,'Rovaniemi','Tundra','Finnish Lapland','North Atlantic','>No Information Currently Available','63000','0.938','47461','0','-0.1','0','590.94','455.54418','269.1992777','1.4814','8.287','4.2129','57','74','63');
INSERT INTO provinces  VALUES ('Scandinavia_FinlandNorthOstrobothnia','477,65','464,72','477,77',TRUE,'Oulu','Taiga','North Ostrobothnia','North Atlantic','>No Information Currently Available','200000','0.938','47461','0','-0.05','0','1876','489.18418','917.7095217','3.1018','8.4259','6.4814','59','79','80');
INSERT INTO provinces  VALUES ('Scandinavia_FinlandSouthOstrobothnia','465,81','464,72','477,77',TRUE,'Vaasa','Taiga','Ostrobothnia','North Atlantic','>No Information Currently Available','66000','0.938','47461','0','-0.05','0','619.08','472.70418','292.6417038','1.5277','8.3796','4.3055','57','79','64');
INSERT INTO provinces  VALUES ('Scandinavia_FinlandSatakunta','465,81','470,89','477,77',TRUE,'Helsinki','Taiga','Uusimaa','North Atlantic','>No Information Currently Available','650000','0.938','47461','0','-0.05','0','6097','463.18418','2824.033945','5.8333','8.3101','8.125','77','79','83');
INSERT INTO provinces  VALUES ('MiddleEast_TurkeyAnatoliaEast','525,157','503,154','512,174',TRUE,'Adana','Plains','Adana','Europe','>No Information Currently Available','1700000','0.82','7715','0','0','-0.2','13940','73.263','1021.28622','7.6157','3.6111','6.8055','82','61','65');
INSERT INTO provinces  VALUES ('MiddleEast_TurkeyAnatoliaCentral','512,174','503,154','493,173',TRUE,'Ankara','Savanna','Ankara','Europe','>No Information Currently Available','5600000','0.82','7715','0','0','0','45920','93.263','4282.63696','9.0509','4.6064','8.8194','83','66','83');
INSERT INTO provinces  VALUES ('MiddleEast_TurkeyMarmara','485,155','503,154','493,173',TRUE,'Yalova','Savanna','Marmara','Europe','>No Information Currently Available','100000','0.82','7715','0','0','0','820','93.263','76.47566','1.875','4.6064','1.8981','57','66','57');
INSERT INTO provinces  VALUES ('MiddleEast_TurkeyAegean','485,155','484,167','493,173',TRUE,'Izmir','Savanna','Izmir','Europe','>No Information Currently Available','4300000','0.82','7715','0','0','0','35260','103.263','3641.05338','8.8425','5.1157','8.5185','83','71','83');
INSERT INTO provinces  VALUES ('MiddleEast_TurkeyIstanbul','485,155','477,144','491,140',TRUE,'Istanbul','Savanna','Marmara','Europe','Istanbul - Formerly known as Constantinople [Istanbul | History, Population, Map, & Facts] - Is a historically important city within Republic of Turkey (though, importantly, not the capital), as well as the seat of the Ecumenical Patriarch of Constantinople - the head of the eastern orthodox church [Ecumenical Patriarchate]. Historically the site was the capital of the Eastern Roman Empire, as well as briefly the capital of the entire Roman Empire. The city was annexed by the islamic Ottoman Empire during the 15th century, and remained its capital city until the fall of the Ottoman Empire and the birth of the Republic of Turkey, afterwhich the capital was changed to the city of Ankara.','15000000','0.82','7715','0.6','0','0','123000','63.263','7781.349','9.9074','3.1712','9.3981','134','59','83');
INSERT INTO provinces  VALUES ('MiddleEast_Georgia','514,140','519,132','525,149',TRUE,'Tbilisi','Plains','Georgia','Europe','>No Information Currently Available','1100000','0.812','4405','0','0','-0.2','8932','49.7686','444.5331352','6.875','2.6157','5.0231','81','58','56');
INSERT INTO provinces  VALUES ('MiddleEast_AzerbaijanNorth','525,149','544,136','519,132',FALSE,'Ganja','Plains','Azerbaijan','Indian','>No Information Currently Available','330000','0.756','4721','0','0','-0.2','2494.8','72.09076','179.852028','3.7731','3.5416','3.3796','61','60','48');
INSERT INTO provinces  VALUES ('MiddleEast_AzerbaijanCentral','525,149','544,136','548,152',FALSE,'Baku','Plains','Azerbaijan','Indian','>No Information Currently Available','2300000','0.756','4721','0','0','-0.2','17388','69.69076','1211.782935','8.125','3.4722','6.9907','83','60','65');
INSERT INTO provinces  VALUES ('MiddleEast_AzerbaijanSouth','549,167','548,152','539,172',FALSE,'Ardabil','Plains','Ardabil','Indian','>No Information Currently Available','520000','0.756','4721','0','0','-0.2','3931.2','67.29076','264.5334357','4.5833','3.3333','4.1898','66','60','51');
INSERT INTO provinces  VALUES ('MiddleEast_ArmeniaNorth','525,149','525,157','548,152',TRUE,'Yerevan','Plains','Armenia','Europe','>No Information Currently Available','1000000','0.776','4315','0','0','-0.2','7760','53.4844','415.038944','6.5046','2.7777','4.8379','80','59','55');
INSERT INTO provinces  VALUES ('MiddleEast_ArmeniaSouth','539,172','548,152','525,157',FALSE,'Yeghegnadzor','Plains','Armenia','Indian','>No Information Currently Available','7900','0.776','4315','0','0','-0.2','61.304','36.5724','2.24203441','0.4398','1.7824','0.1851','56','57','45');
INSERT INTO provinces  VALUES ('MiddleEast_IranKhorasan','588,202','579,201','579,181',FALSE,'Mashhad','Plains','Khorasan','Indian',' (Holy site - Zoroastrian great fire location)','3300000','0.783','7257','0.1','0','-0.2','25839','103.82231','2682.664668','8.449','5.1851','7.9861','91','72','66');
INSERT INTO provinces  VALUES ('MiddleEast_IranBaluchistan','588,202','579,201','581,216',FALSE,'Zahedan','Plains','Baluchistan','Indian','>No Information Currently Available','580000','0.783','7257','0','0','-0.2','4541.4','99.02231','449.6999186','4.9074','4.9768','5.0694','69','70','57');
INSERT INTO provinces  VALUES ('MiddleEast_IranGulf','553,197','579,201','581,216',TRUE,'Isfahan','Plains','Isfahan','Indian','>No Information Currently Available','2000000','0.783','7257','0','0','-0.2','15660','86.82231','1359.637375','7.9166','4.1435','7.1296','82','63','65');
INSERT INTO provinces  VALUES ('MiddleEast_IranSouthCentral','553,197','579,201','579,181',FALSE,'Shiraz','Plains','Fars','Indian','(Holy site - bahai house of bab)','3300000','0.783','7257','0.2','0','-0.2','25839','103.82231','2682.664668','8.449','5.1851','7.9861','99','72','66');
INSERT INTO provinces  VALUES ('MiddleEast_IranNorthCentral','553,197','555,178','579,181',FALSE,'Kerman','Plains','Kerman','Indian','>No Information Currently Available','780000','0.783','7257','0','0','-0.2','6107.4','67.02231','409.3320561','5.8796','3.3101','4.8148','77','60','55');
INSERT INTO provinces  VALUES ('MiddleEast_IranSemnan','562,173','555,178','579,181',FALSE,'Tehran','Plains','Tehran','Indian','>No Information Currently Available','9000000','0.783','7257','0','0','-0.2','70470','66.82231','4708.968186','9.4907','3.287','8.9351','84','60','67');
INSERT INTO provinces  VALUES ('MiddleEast_IranCaspian','549,167','555,178','562,173',FALSE,'Tabriz','Plains','Gilan','Indian','>No Information Currently Available','1500000','0.783','7257','0','0','-0.2','11745','91.82231','1078.453031','7.4074','4.4444','6.9212','82','65','65');
INSERT INTO provinces  VALUES ('MiddleEast_IranAzerbaijan','549,167','555,178','539,172',FALSE,'Urmia','Plains','Azerbaijan','Indian','>No Information Currently Available','730000','0.783','7257','0','0','-0.2','5715.9','87.52231','500.2687717','5.7175','4.1898','5.3009','76','63','58');
INSERT INTO provinces  VALUES ('MiddleEast_IranKurdistan','553,197','555,178','539,172',FALSE,'Sanandaj','Plains','Kurdistan','Indian','>No Information Currently Available','400000','0.783','7257','0','0','-0.2','3132','92.82231','290.7194749','4.1435','4.537','4.2824','63','66','51');
INSERT INTO provinces  VALUES ('MiddleEast_SyriaNorth','525,157','539,172','512,174',FALSE,'Aleppo','Plains','Syria','Europe','>No Information Currently Available','1800000','0.567','2114','0','0','-0.2','10206','55.98638','571.3969943','7.1064','2.9166','5.6712','81','59','61');
INSERT INTO provinces  VALUES ('MiddleEast_SyriaSouth','510,186','539,172','512,174',TRUE,'Damascus','Plains','Syria','Europe','>No Information Currently Available','2000000','0.567','2114','0','0','-0.2','11340','21.98638','249.3255492','7.2685','0.7175','4.0277','82','57','50');
INSERT INTO provinces  VALUES ('MiddleEast_IraqWest','510,186','539,172','533,192',FALSE,'Ramadi','Plains','Al Anbar','Europe','>No Information Currently Available','220000','0.674','4438','0','0','-0.2','1482.8','75.51212','111.9693715','2.6851','3.7037','2.4074','58','61','46');
INSERT INTO provinces  VALUES ('MiddleEast_IraqEast','553,197','539,172','533,192',FALSE,'Baghdad','Plains','Baghdad','Indian','>No Information Currently Available','8100000','0.674','4438','0','0','-0.2','54594','67.91212','3707.594279','9.1435','3.3796','8.5879','83','60','66');
INSERT INTO provinces  VALUES ('MiddleEast_IraqSouth','553,197','535,192','519,200',FALSE,'Samawah','Desert','Muthanna','Indian','>No Information Currently Available','150000','0.674','4438','0','0','0','1011','51.91212','52.48315332','2.2222','2.7083','1.5972','58','58','57');
INSERT INTO provinces  VALUES ('MiddleEast_Kuwait','553,197','553,207','519,200',TRUE,'Kuwait city','Desert','Kuwait','Indian','>No Information Currently Available','32000','0.806','22252','0','0','0','257.92','197.27112','50.88016727','0.9259','6.7361','1.574','57','80','57');
INSERT INTO provinces  VALUES ('MiddleEast_Jordan','510,186','533,192','519,200',FALSE,'Amman','Desert','Jordan','Europe','>No Information Currently Available','4300000','0.729','4174','0','0','0','31347','41.42846','1298.657936','8.7268','2.1064','7.0601','83','58','81');
INSERT INTO provinces  VALUES ('MiddleEast_Jerusalem','510,186','510,201','519,200',TRUE,'Jerusalem','Desert','Jerusalem','Europe','Jerusalem is the disputed capital of both the states of Israel and Palestine, as the city holds arguably the most religious importance in the world - being a holy city to all the ahbrahamic religions (the primary three being Judaism, Christianity and Islam). The city claims to have once been ruled by King David [The Twelve Tribes of Israel] [King David], the uniter of the Israeli people, and is nearby the site of Bethlehem - the birth place of the prophet Jesus Christ within the Christian and Islamic Churches.','900000','0.919','41560','0.8','0','0','8271','413.9364','3423.667964','6.6898','7.9629','8.4259','145','82','83');
INSERT INTO provinces  VALUES ('MiddleEast_ArabiaMadinah','524,226','510,201','519,200',TRUE,'Madinah','Desert','Medina','Indian','>No Information Currently Available','1100000','0.854','19587','0','0','0','9394','169.27298','1590.150374','6.9907','6.574','7.2916','81','80','82');
INSERT INTO provinces  VALUES ('MiddleEast_ArabiaMakkah','551,247','529,239','536,233',FALSE,'Al Baha','Desert','Al Bahah','Indian','>No Information Currently Available','100000','0.854','19587','0','0','0','854','199.27298','170.1791249','1.9907','6.7592','3.1712','58','81','59');
INSERT INTO provinces  VALUES ('MiddleEast_ArabiaMecca','524,226','529,239','536,233',TRUE,'Mecca','Desert','Mecca','Indian','(Holy site - Islamic grand mosque)','2000000','0.854','19587','0.6','0','0','17080','207.27298','3540.222498','8.1018','6.8518','8.4953','132','81','83');
INSERT INTO provinces  VALUES ('MiddleEast_ArabiaAsir','538,256','529,239','551,247',TRUE,'Abha','Desert','Asir','Indian','>No Information Currently Available','780000','0.854','19587','0','0','0','6661.2','206.87298','1378.022294','6.0879','6.8287','7.1527','78','81','81');
INSERT INTO provinces  VALUES ('MiddleEast_ArabiaTabuk','524,226','536,233','519,200',FALSE,'Tabuk','Desert','Tabuk','Indian','>No Information Currently Available','550000','0.854','19587','0','0','0','4697','168.27298','790.3781871','5.0231','6.5277','6.1805','70','80','79');
INSERT INTO provinces  VALUES ('MiddleEast_ArabiaRiyadh','553,220','536,233','551,247',FALSE,'Riyadh','Desert','Riyadh','Indian','>No Information Currently Available','7600000','0.854','19587','0','0','0','64904','199.27298','12933.61349','9.4212','6.7592','9.7685','83','81','84');
INSERT INTO provinces  VALUES ('MiddleEast_ArabiaHayil','536,233','519,200','553,220',FALSE,'Hail','Desert','Hail','Indian','>No Information Currently Available','600000','0.854','19587','0','0','0','5124','209.27298','1072.31475','5.2546','6.875','6.8981','72','81','81');
INSERT INTO provinces  VALUES ('MiddleEast_ArabiaAlHodud','553,220','519,200','553,207',FALSE,'Buraidah','Desert','Qasim','Indian','>No Information Currently Available','610000','0.854','19587','0','0','0','5209.4','167.47298','872.433742','5.3703','6.4814','6.412','74','80','80');
INSERT INTO provinces  VALUES ('MiddleEast_ArabiaAsSharqiyahNorth','584,225','553,220','553,207',TRUE,'Dammam','Desert','Ash Sharqiyah','Indian','>No Information Currently Available','1000000','0.854','19587','0','0','0','8540','187.27298','1599.311249','6.7592','6.7129','7.3148','81','80','82');
INSERT INTO provinces  VALUES ('MiddleEast_ArabiaDesertEast','573,237','584,225','553,220',FALSE,'Shaybah','Desert','Ash Sharqiyah','Indian','>No Information Currently Available','1500','0.854','19587','0','0','0','12.81','168.50298','2.158523174','0.1388','6.5509','0.1388','56','80','56');
INSERT INTO provinces  VALUES ('MiddleEast_ArabiaDesertWest','573,237','551,247','553,220',FALSE,'Layla','Desert','Ash Sharqiyah','Indian','>No Information Currently Available','76000','0.854','19587','0','0','0','649.04','179.59298','116.5630277','1.5972','6.5972','2.5231','57','80','58');
INSERT INTO provinces  VALUES ('MiddleEast_OmanEast','584,225','582,241','573,237',TRUE,'Nizwa','Desert','Oman','Indian','>No Information Currently Available','120000','0.813','14423','0','0','0','975.6','118.45899','115.5685906','2.1527','5.8564','2.5','58','77','58');
INSERT INTO provinces  VALUES ('MiddleEast_OmanNorth','551,247','582,241','573,237',FALSE,'Muscat','Desert','Oman','Indian','>No Information Currently Available','24000','0.813','14423','0','0','0','195.12','117.49899','22.92640293','0.787','5.8333','0.9722','57','77','57');
INSERT INTO provinces  VALUES ('MiddleEast_OmanSouth','551,247','582,241','558,258',TRUE,'Salalah','Desert','Oman','Indian','>No Information Currently Available','340000','0.813','14423','0','0','0','2764.2','120.65899','333.5255802','3.9814','6.0185','4.3981','62','78','65');
INSERT INTO provinces  VALUES ('MiddleEast_YemenNorth','551,247','538,256','558,258',FALSE,'Sanaa','Desert','Yemen','Indian','>No Information Currently Available','2500000','0.47','645','0','0','0','11750','3.0315','35.620125','7.4305','0.0462','1.3657','82','56','57');
INSERT INTO provinces  VALUES ('MiddleEast_YemenSouth','543,265','538,256','558,258',TRUE,'Aden','Desert','Yemen','Indian','>No Information Currently Available','860000','0.47','645','0','0','0','4042','49.0315','198.185323','4.6527','2.3611','3.5416','67','58','60');
INSERT INTO provinces  VALUES ('Africa_EgyptSuez','510,201','499,203','498,191',TRUE,'Suez','Desert','Suez','Europe','The city of Suez is a major seaport within the Arab Republic of Egypt, most notably containing the Suez Canal, a grand canal that connects the Mediterranean Sea to the Red sea on the Arabian Peninsula, permitting oceanic travel between Europe and Asia without navigating around the continent of Africa','740000','0.707','3561','0.1','0','0','5231.8','41.37627','216.4723694','5.3935','2.0833','3.7731','81','58','61');
INSERT INTO provinces  VALUES ('Africa_EgyptRedSea','510,201','499,203','514,224',TRUE,'Hurghada','Desert','Red Sea','Indian','>No Information Currently Available','260000','0.707','3561','0','0','0','1838.2','38.97627','71.64617951','3.0092','1.9675','1.8518','59','57','57');
INSERT INTO provinces  VALUES ('Africa_EgyptCairo','473,204','499,203','498,191',FALSE,'Cairo','Desert','Cairo','Europe','>No Information Currently Available','9500000','0.707','3561','0','0','0','67165','60.17627','4041.739175','9.4675','3.0324','8.7731','84','59','83');
INSERT INTO provinces  VALUES ('Africa_EgyptMatruh','473,204','476,187','498,191',TRUE,'Marsa Matruh','Desert','Matruh','Europe','>No Information Currently Available','68000','0.707','3561','0','0','0','480.76','38.01627','18.27670197','1.25','1.875','0.787','57','57','57');
INSERT INTO provinces  VALUES ('Africa_EgyptNewValleyWest','476,224','499,203','473,204',FALSE,'Farafra','Desert','New Valley','Indian','>No Information Currently Available','5000','0.707','3561','0','0','0','35.35','40.82627','1.443208644','0.3009','2.0601','0.0462','56','58','56');
INSERT INTO provinces  VALUES ('Africa_EgyptNewValleyEast','476,224','499,203','514,224',FALSE,'Kharga','Desert','New Valley','Indian','(Pyramids)','67000','0.707','3561','0.6','0','0','473.69','34.88627','16.52527724','1.2037','1.6203','0.6712','91','57','57');
INSERT INTO provinces  VALUES ('Africa_LibyaDerna','476,187','473,204','464,188',TRUE,'Derna','Desert','Derna','Europe','>No Information Currently Available','100000','0.724','3282','0','0','0','724','61.76168','44.71545632','1.7592','3.0787','1.4814','57','59','57');
INSERT INTO provinces  VALUES ('Africa_LibyaEdjabia','440,204','473,204','464,188',FALSE,'Ajdabiya','Desert','Al Wahat','Europe','>No Information Currently Available','410000','0.724','3282','0','0','0','2968.4','34.56168','102.5928909','4.0972','1.5277','2.2916','63','57','58');
INSERT INTO provinces  VALUES ('Africa_LibyaSirt','440,204','439,182','464,188',TRUE,'Tripoli','Desert','Tripoli','Europe','>No Information Currently Available','3000000','0.724','3282','0','0','0','21720','63.76168','1384.90369','8.3333','3.2407','7.1759','83','59','81');
INSERT INTO provinces  VALUES ('Africa_LibyaAlkufra','476,224','473,204','440,204',FALSE,'Al Jawf','Desert','Kufra','Europe','>No Information Currently Available','17000','0.724','3282','0','0','0','123.08','38.72168','4.765864374','0.6018','1.8981','0.324','57','57','56');
INSERT INTO provinces  VALUES ('Africa_Tunisia','423,171','439,182','438,169',TRUE,'Tunis','Savanna','Tunisia','Europe','(Carthage site)','11000000','0.74','3295','0.1','0','0','81400','24.383','1984.7762','9.6759','0.9027','7.6388','92','57','82');
INSERT INTO provinces  VALUES ('Africa_AlgeriaAlgiers','423,171','439,182','405,175',TRUE,'Algiers','Savanna','Algiers','Europe','>No Information Currently Available','3900000','0.748','3331','0','0','0','29172','48.91588','1426.974051','8.6805','2.3148','7.199','83','58','81');
INSERT INTO provinces  VALUES ('Africa_AlgeriaTamanghasset','440,204','439,182','405,175',FALSE,'Tanmanrasset','Desert','Tanmanrasset','Europe','>No Information Currently Available','92000','0.748','3331','0','0','0','688.16','49.63588','34.15742718','1.7129','2.5925','1.3425','57','58','57');
INSERT INTO provinces  VALUES ('Africa_AlgeriaAdrar','440,204','406,192','405,175',FALSE,'Adrar','Desert','Adrar','Europe','>No Information Currently Available','64000','0.748','3331','0','0','0','478.72','55.15588','26.40422287','1.2268','2.8935','1.1111','57','59','57');
INSERT INTO provinces  VALUES ('Africa_AlgeriaBechar','379,191','406,192','405,175',FALSE,'Bechar','Desert','Bechar','Europe','>No Information Currently Available','270000','0.748','3331','0','0','0','2019.6','68.11588','137.5668312','3.3333','3.4027','2.7083','60','60','58');
INSERT INTO provinces  VALUES ('Africa_Morocco','379,191','385,177','405,175',TRUE,'Rabat','Savanna','Morocco','Europe','>No Information Currently Available','570000','0.686','3121','0','0','0','3910.2','42.41006','165.8318166','4.5601','2.1759','3.125','66','58','59');
INSERT INTO provinces  VALUES ('Africa_SaharaSouth','476,224','366,241','440,204',FALSE,'Gao','Desert','South Sahara','West Africa','>No Information Currently Available','86000','0.546','1791','0','0','0','469.56','30.29886','14.2271327','1.1805','1.2962','0.625','57','57','57');
INSERT INTO provinces  VALUES ('Africa_SaharaNorth','369,205','366,241','440,204',FALSE,'Tamanrasset','Desert','North Sahara','West Africa','>No Information Currently Available','92000','0.546','1791','0','0','0','502.32','35.21886','17.69113776','1.2731','1.6666','0.7407','57','57','57');
INSERT INTO provinces  VALUES ('Africa_MauritaniaEast','369,205','406,192','440,204',FALSE,'Atar','Desert','Mauritania','West Africa','>No Information Currently Available','25000','0.546','1791','0','0','0','136.5','30.27886','4.13306439','0.6481','1.2731','0.3009','57','57','56');
INSERT INTO provinces  VALUES ('Africa_MauritaniaWest','369,205','366,241','358,242',TRUE,'Nouakchott','Desert','Mauritania','West Africa','>No Information Currently Available','950000','0.546','1791','0','0','0','5187','38.77886','201.1459468','5.324','1.9444','3.6111','73','57','61');
INSERT INTO provinces  VALUES ('Africa_WestSaharaState','369,205','406,192','379,191',TRUE,'Laayoune','Desert','West Sahara','West Africa','>No Information Currently Available','200000','0.546','1791','0','0','0','1092','23.77886','25.96651512','2.2916','0.8564','1.0879','58','57','57');
INSERT INTO provinces  VALUES ('Africa_SudanPort','524,245','476,224','514,224',TRUE,'Port Sudan','Desert','Sudan','Indian','>No Information Currently Available','480000','0.51','735','0','0','0','2448','45.7485','111.992328','3.7268','2.2453','2.4305','61','58','58');
INSERT INTO provinces  VALUES ('Africa_SudanKordofanNorth','524,245','476,224','480,252',FALSE,'Khartoum','Desert','Sudan','Indian','>No Information Currently Available','630000','0.51','735','0','0','0','3213','5.7485','18.4699305','4.1898','0.0925','0.8564','63','56','57');
INSERT INTO provinces  VALUES ('Africa_SudanKordofanSouth','524,245','517,267','480,252',FALSE,'Al-Ubayyid','Desert','Sudan','Indian','>No Information Currently Available','410000','0.51','735','0','0','0','2091','17.7485','37.1121135','3.4027','0.5787','1.412','60','57','57');
INSERT INTO provinces  VALUES ('Africa_SouthSudan','508,279','517,267','480,252',FALSE,'Juba','Desert','South Sudan','Indian','The city of Juba is capital to the nation of South Sudan, considered the newest nation as of writing with international recognition. The republic of South Sudan was formerly occupied by the Republic of Sudan (which sits to its north). South Sudan is considered a volatile region, ranking high on the Fragile States Index [Global Data | Fragile States Index, 2020]','500000','0.433','303','0','0','0','2165','1.31199','2.84045835','3.4953','0','0.2314','60','56','56');
INSERT INTO provinces  VALUES ('Africa_Eritrea','524,245','517,267','539,271',TRUE,'Asmara','Desert','Eritrea','Indian','>No Information Currently Available','960000','0.459','585','0','0','0','4406.4','13.88515','61.18352496','4.7916','0.4861','1.6898','68','56','57');
INSERT INTO provinces  VALUES ('Africa_EthiopiaAmhara','508,279','517,267','539,271',FALSE,'Bahir Dar','Desert','Amhara','Indian','>No Information Currently Available','170000','0.485','974','0','0','0','824.5','7.7239','6.36835555','1.8981','0.1388','0.3935','57','56','56');
INSERT INTO provinces  VALUES ('Africa_EthiopiaOromiya','508,279','539,296','539,271',FALSE,'Addis Ababa','Savanna','Oromiya','Indian','>No Information Currently Available','3300000','0.485','974','0','0','0','16005','24.7239','395.7060195','7.9861','0.9953','4.7222','82','57','67');
INSERT INTO provinces  VALUES ('Africa_EthiopiaSomali','560,282','539,296','539,271',FALSE,'Jigjiga','Savanna','Somali','Indian','>No Information Currently Available','760000','0.485','974','0','0','0','3686','38.7239','142.7362954','4.3981','1.9212','2.8009','65','57','59');
INSERT INTO provinces  VALUES ('Africa_Somalia','543,309','539,296','560,282',TRUE,'Mogadishu','Savanna','Somalia','East Africa','>No Information Currently Available','2200000','0.351','105','0','0','0','7722','2.36855','18.2899431','6.4583','0.0231','0.8101','80','56','57');
INSERT INTO provinces  VALUES ('Africa_SomaliaHorn','561,266','539,271','560,282',TRUE,'Djibouti','Savanna','Horn Of Africa','East Africa','>No Information Currently Available','920000','0.351','105','0','0','0','3229.2','7.56855','24.44036166','4.2361','0.1157','1.0416','63','56','57');
INSERT INTO provinces  VALUES ('Africa_KenyaEast','543,309','539,296','529,323',TRUE,'Mombasa','Savanna','Kenya','East Africa','>No Information Currently Available','1200000','0.601','2075','0','0','0','7212','20.47075','147.635049','6.3194','0.6712','2.8703','79','57','59');
INSERT INTO provinces  VALUES ('Africa_KenyaWest','508,279','539,296','529,323',FALSE,'Nairobi','Savanna','Kenya','East Africa','>No Information Currently Available','4300000','0.601','2075','0','0','0','25843','24.47075','632.3975923','8.4953','0.9259','5.787','83','57','77');
INSERT INTO provinces  VALUES ('Africa_TanzaniaSouth','527,356','498,343','529,323',TRUE,'Mtwara','Savanna','Tanzania','East Africa','>No Information Currently Available','100000','0.529','1106','0','0','0','529','24.85074','13.14604146','1.3425','1.0185','0.6018','57','57','57');
INSERT INTO provinces  VALUES ('Africa_TanzaniaNorth','501,311','498,343','529,323',FALSE,'Dar es Salaam','Savanna','Tanzania','East Africa','>No Information Currently Available','7400000','0.529','1106','0','0','0','39146','11.85074','463.909068','8.912','0.2546','5.162','83','56','72');
INSERT INTO provinces  VALUES ('Africa_Uganda','501,311','508,279','529,323',FALSE,'Kampala','Savanna','Uganda','East Africa','>No Information Currently Available','1600000','0.544','915','0','0','0','8704','22.9776','199.9970304','6.8287','0.8333','3.5879','81','57','60');
INSERT INTO provinces  VALUES ('Africa_MozambiqueNorth','527,356','498,343','519,385',TRUE,'Lilongwe','Savanna','Mozambique','East Africa','>No Information Currently Available','980000','0.456','455','0','0','0','4468.8','34.8748','155.8485062','4.8611','1.5972','2.9629','69','57','59');
INSERT INTO provinces  VALUES ('Africa_MozambiqueSouth','511,411','494,403','519,385',TRUE,'Maputo','Savanna','Mozambique','East Africa','>No Information Currently Available','1000000','0.456','455','0','0','0','4560','12.0748','55.061088','4.9305','0.2777','1.6203','69','56','57');
INSERT INTO provinces  VALUES ('Africa_Zambia','486,371','498,343','519,385',FALSE,'Lusaka','Savanna','Zambia','East Africa','>No Information Currently Available','1700000','0.584','1001','0','0','0','9928','17.84584','177.1734995','7.0833','0.6018','3.287','81','57','60');
INSERT INTO provinces  VALUES ('Africa_Zimbabwe','486,371','494,403','519,385',FALSE,'Harare','Savanna','Zimbabwe','East Africa','>No Information Currently Available','2100000','0.571','922','0','0','0','11991','30.26462','362.9030584','7.4537','1.25','4.537','82','57','66');
INSERT INTO provinces  VALUES ('Africa_SouthAfricaLimpopo','479,418','494,403','511,411',FALSE,'Polokwane','Savanna','Limpopo','East Africa','>No Information Currently Available','130000','0.709','4736','0','0','0','921.7','73.87824','68.09357381','2.1296','3.6342','1.7824','58','61','57');
INSERT INTO provinces  VALUES ('Africa_SouthAfricaKwazulu-Natal','479,418','486,446','511,411',TRUE,'Durban','Savanna','KwaZula-Natal','East Africa','>No Information Currently Available','3700000','0.709','4736','0','0','0','26233','80.57824','2113.80897','8.5185','3.8657','7.7314','83','62','82');
INSERT INTO provinces  VALUES ('Africa_SouthAfricaCape','479,418','486,446','462,450',TRUE,'Port Elizabeth','Savanna','Cape Of Good Hope','East Africa','>No Information Currently Available','960000','0.709','4736','0','0','0','6806.4','81.17824','552.5315727','6.1574','3.9351','5.5324','79','62','75');
INSERT INTO provinces  VALUES ('Africa_SouthAfricaCapeWest','479,418','453,422','462,450',TRUE,'Cape Town','Savanna','Cape Of Good Hope','West Africa','>No Information Currently Available','3700000','0.709','4736','0','0','0','26233','80.57824','2113.80897','8.5185','3.8657','7.7314','83','62','82');
INSERT INTO provinces  VALUES ('Africa_SouthAfricaNorth','479,418','494,403','446,391',FALSE,'Johannesburg','Desert','Gauteng','West Africa','>No Information Currently Available','5600000','0.709','4736','0','0','0','39704','69.57824','2762.534441','8.9351','3.449','8.0787','83','60','83');
INSERT INTO provinces  VALUES ('Africa_Namibia','479,418','453,422','446,391',TRUE,'Windhoek','Desert','Namibia','West Africa','>No Information Currently Available','320000','0.646','4052','0','0','0','2067.2','27.37592','56.59150182','3.3796','1.1574','1.6666','60','57','57');
INSERT INTO provinces  VALUES ('Africa_Angola','448,359','486,371','446,391',TRUE,'Luanda','Desert','Angola','West Africa','>No Information Currently Available','2500000','0.581','2021','0','0','0','14525','11.74201','170.5526953','7.6851','0.2314','3.2175','82','56','59');
INSERT INTO provinces  VALUES ('Africa_Botswana','494,403','486,371','446,391',FALSE,'Gaborone','Desert','Botswana','West Africa','>No Information Currently Available','230000','0.735','6558','0','0','0','1690.5','90.2013','152.4852977','2.8935','4.2824','2.9398','59','64','59');
INSERT INTO provinces  VALUES ('Africa_DRCKatanga','448,359','486,371','498,343',FALSE,'Lubumbashi','Desert','Katanga','West Africa','>No Information Currently Available','1700000','0.48','457','0','0','0','8160','22.1936','181.099776','6.5972','0.7407','3.4027','80','57','60');
INSERT INTO provinces  VALUES ('Africa_DRCBandundu','448,359','435,317','498,343',TRUE,'Bandudu','Jungle','Bandudu','West Africa','>No Information Currently Available','140000','0.48','457','0','0','0.1','672','26.1936','17.6020992','1.6898','1.0648','0.6944','57','57','62');
INSERT INTO provinces  VALUES ('Africa_DRCManiema','501,311','435,317','498,343',FALSE,'Kindu','Jungle','Maniema','West Africa','>No Information Currently Available','170000','0.48','457','0','0','0.1','816','24.1936','19.7419776','1.8287','0.8796','0.8796','57','57','62');
INSERT INTO provinces  VALUES ('Africa_DRCEquateur','501,311','435,317','508,279',FALSE,'Mbandaka','Jungle','Equateur','West Africa','>No Information Currently Available','1100000','0.48','457','0','0','0.1','5280','12.1936','64.382208','5.4398','0.3935','1.7361','74','56','63');
INSERT INTO provinces  VALUES ('Africa_CentralAfricanRepublic','453,274','435,317','508,279',FALSE,'Bangui','Jungle','Central African Republic','West Africa','>No Information Currently Available','700000','0.397','480','0','0','0.1','2779','22.9056','63.6546624','4.0046','0.787','1.7129','62','57','63');
INSERT INTO provinces  VALUES ('Africa_ChadSouth','453,274','480,252','508,279',FALSE,'Lai','Savanna','Tandjile','West Africa','>No Information Currently Available','20000','0.398','640','0','0','0','79.6','22.9472','1.82659712','0.5092','0.8101','0.0694','56','57','56');
INSERT INTO provinces  VALUES ('Africa_ChadNorth','423,249','480,252','476,224',FALSE,'Fada','Savanna','Fada','West Africa','>No Information Currently Available','23000','0.398','640','0','0','0','91.54','26.0072','2.380699088','0.5324','1.0416','0.2083','56','57','56');
INSERT INTO provinces  VALUES ('Africa_ChadWest','453,274','480,252','423,249',FALSE,'NDjamena','Savanna','NDjamena','West Africa','>No Information Currently Available','950000','0.398','640','0','0','0','3781','21.5472','81.4699632','4.4444','0.6944','1.9907','65','57','58');
INSERT INTO provinces  VALUES ('Africa_Nigeria','453,274','417,290','423,249',FALSE,'Abuja','Savanna','Nigeria','West Africa','>No Information Currently Available','1200000','0.539','2149','0','0','0','6468','31.58311','204.2795555','5.949','1.3888','3.6574','78','57','61');
INSERT INTO provinces  VALUES ('Africa_Cameroon','435,317','453,274','417,290',TRUE,'Yaounde','Jungle','Cameroon','West Africa','>No Information Currently Available','2700000','0.563','1493','0','0','0.1','15201','31.40559','477.3963736','7.824','1.3425','5.2083','82','57','79');
INSERT INTO provinces  VALUES ('Africa_NigerEast','423,249','366,241','476,224',FALSE,'Agadez','Savanna','Niger','West Africa','>No Information Currently Available','110000','0.394','536','0','0','0','433.4','51.91184','22.49859146','1.1574','2.6851','0.9259','57','58','57');
INSERT INTO provinces  VALUES ('Africa_NigerWest','423,249','417,290','394,269',FALSE,'Niamey','Jungle','Niger','West Africa','>No Information Currently Available','1000000','0.394','536','0','0','0.1','3940','32.11184','126.5206496','4.6064','1.412','2.662','66','57','64');
INSERT INTO provinces  VALUES ('Africa_Ghana','394,294','417,290','394,269',TRUE,'Accra','Jungle','Ghana','West Africa','>No Information Currently Available','5000000','0.611','2188','0','0','0.1','30550','13.36868','408.413174','8.7037','0.4629','4.7916','83','56','75');
INSERT INTO provinces  VALUES ('Africa_IvoryCoastNorth','394,294','379,282','394,269',FALSE,'Korhogo','Jungle','Ivory Coast','West Africa','>No Information Currently Available','280000','0.538','2276','0','0','0.1','1506.4','28.24488','42.54808723','2.7546','1.2037','1.4583','58','57','63');
INSERT INTO provinces  VALUES ('Africa_IvoryCoastSouth','394,294','379,282','383,298',TRUE,'Yamoussoukro','Jungle','Ivory Coast','West Africa','>No Information Currently Available','360000','0.538','2276','0','0','0.1','1936.8','54.24488','105.0614836','3.1944','2.8472','2.3611','59','59','64');
INSERT INTO provinces  VALUES ('Africa_Liberia','365,277','379,282','383,298',TRUE,'Monrovia','Jungle','Liberia','West Africa','>No Information Currently Available','1000000','0.48','654','0','0','0.1','4800','3.1392','15.06816','5.1388','0.0694','0.6481','71','56','62');
INSERT INTO provinces  VALUES ('Africa_EastGuinea','365,277','379,282','394,269',FALSE,'Kankan','Savanna','Guinea','West Africa','>No Information Currently Available','190000','0.592','7131','0','0','0','1124.8','75.81552','85.2772969','2.3148','3.7268','2.0601','58','61','58');
INSERT INTO provinces  VALUES ('Africa_WestGuinea','365,277','354,261','394,269',TRUE,'Conakry','Savanna','Guinea','West Africa','>No Information Currently Available','1600000','0.592','7131','0','0','0','9472','46.21552','437.7534054','7.0138','2.2685','5','81','58','70');
INSERT INTO provinces  VALUES ('Africa_Senegal','358,242','354,261','366,241',TRUE,'Dakar','Savanna','Senegal','West Africa','>No Information Currently Available','1100000','0.512','1455','0','0','0','5632','17.4496','98.2761472','5.6944','0.5555','2.199','76','57','58');
INSERT INTO provinces  VALUES ('Africa_MaliWest','394,269','354,261','366,241',FALSE,'Bamako','Savanna','Mali','West Africa','>No Information Currently Available','2700000','0.434','899','0','0','0','11718','13.90166','162.8996519','7.3842','0.5092','3.0555','82','56','59');
INSERT INTO provinces  VALUES ('Africa_MaliEast','394,269','423,249','366,241',FALSE,'Timbuktu','Desert','Mali','West Africa','>No Information Currently Available','54000','0.434','899','0','0','0','234.36','51.10166','11.97618504','0.8796','2.662','0.5092','57','58','56');
INSERT INTO provinces  VALUES ('Madagascar_Boeny','540,392','540,379','556,363',TRUE,'Mahajanga','Jungle','Boeny','East Africa','>No Information Currently Available','220000','0.528','515','0','0','0.1','1161.6','10.3192','11.98678272','2.3379','0.2083','0.5324','58','56','62');
INSERT INTO provinces  VALUES ('Madagascar_Sava','540,392','560,377','556,363',TRUE,'Sambava','Jungle','Sava','East Africa','>No Information Currently Available','40000','0.528','515','0','0','0.1','211.2','35.9192','7.58613504','0.8333','1.7361','0.4166','57','57','62');
INSERT INTO provinces  VALUES ('Madagascar_Androy','540,392','560,377','544,414',TRUE,'Ambovombe-Androy','Jungle','Androy','East Africa','>No Information Currently Available','110000','0.528','515','0','0','0.1','580.8','31.5192','18.30635136','1.4583','1.3657','0.8333','57','57','62');
INSERT INTO provinces  VALUES ('Madagascar_Menabe','540,392','536,407','544,414',TRUE,'Morondava','Savanna','Menabe','East Africa','>No Information Currently Available','120000','0.528','515','0','0','0','633.6','52.3192','33.14944512','1.5509','2.7546','1.3194','57','58','57');
INSERT INTO provinces  VALUES ('Russia_KrasnodarKrai','505,136','519,132','518,121',TRUE,'Krasnodar','Forest','Krasnodar Krai','Europe','>No Information Currently Available','720000','0.824','9972','0','0','0.1','5932.8','113.36928','672.5972644','5.787','5.6481','5.8333','77','76','85');
INSERT INTO provinces  VALUES ('Russia_Kola','473,45','477,65','492,51',TRUE,'Murmansk','Tundra','Kola','Steppes','>No Information Currently Available','300000','0.824','9972','0','-0.1','0','2472','120.16928','297.0584602','3.75','5.9259','4.3287','61','70','64');
INSERT INTO provinces  VALUES ('Russia_Karelia','477,65','477,77','501,53',TRUE,'Petrozavodsk','Tundra','Karelia','Steppes','>No Information Currently Available','260000','0.824','9972','0','-0.1','0','2142.4','101.76928','218.0305055','3.4259','5.0231','3.8194','60','63','61');
INSERT INTO provinces  VALUES ('Russia_Leningrad','478,101','477,77','470,89',FALSE,'Saint Petersburg','Forest','Leningrad','Steppes','>No Information Currently Available','5300000','0.824','9972','0','0','0.1','43672','120.16928','5248.032796','8.9583','5.9259','8.9814','83','77','92');
INSERT INTO provinces  VALUES ('Russia_Novgorod','478,101','477,77','502,99',FALSE,'Veliky Novgorod','Forest','Novgorod','Steppes','>No Information Currently Available','210000','0.824','9972','0','0','0.1','1730.4','103.76928','179.5623621','2.9398','5.162','3.3333','59','72','66');
INSERT INTO provinces  VALUES ('Russia_Arkhangelsk','502,99','477,77','501,53',FALSE,'Arkhangelsk','Taiga','Arkhangelsk','Steppes','>No Information Currently Available','340000','0.824','9972','0','-0.05','0','2801.6','88.56928','248.1356948','4.0277','4.2361','4.0046','62','60','62');
INSERT INTO provinces  VALUES ('Russia_Smolensk','478,101','494,121','502,99',FALSE,'Smolensk','Forest','Smolensk','Steppes','>No Information Currently Available','320000','0.824','9972','0','0','0.1','2636.8','129.36928','341.1209175','3.912','6.3194','4.4675','62','79','72');
INSERT INTO provinces  VALUES ('Russia_Moscow','518,121','494,121','502,99',FALSE,'Moscow','Forest','Moscow','Steppes','>No Information Currently Available','13000000','0.824','9972','0','0','0.1','107120','112.16928','12015.57327','9.8611','5.4861','9.7453','84','75','92');
INSERT INTO provinces  VALUES ('Russia_Krasnodar','519,132','518,121','544,136',FALSE,'Aktobe','Plains','Kazakhstan','Europe','>No Information Currently Available','500000','0.824','9972','0','0','-0.2','4120','112.16928','462.1374336','4.6759','5.4861','5.1388','67','75','57');
INSERT INTO provinces  VALUES ('Russia_Volgograd','563,131','518,121','544,136',FALSE,'Volgograd','Plains','Volgograd','Europe','>No Information Currently Available','1000000','0.824','9972','0','0','-0.2','8240','92.16928','759.4748672','6.6435','4.4675','6.0879','80','65','63');
INSERT INTO provinces  VALUES ('Russia_Voronezh','502,99','529,98','518,121',FALSE,'Voronezh','Forest','Voronezh','Steppes','>No Information Currently Available','1000000','0.824','9972','0','0','0.1','8240','92.16928','759.4748672','6.6435','4.4675','6.0879','80','65','86');
INSERT INTO provinces  VALUES ('Russia_Saratov','563,131','529,98','518,121',FALSE,'Saratov','Plains','Saratov','Steppes','>No Information Currently Available','830000','0.824','9972','0','0','-0.2','6839.2','88.96928','608.4786998','6.2037','4.2592','5.6944','79','64','61');
INSERT INTO provinces  VALUES ('Russia_Komi','502,99','501,53','552,75',FALSE,'Syktyvkar','Taiga','Komi','Steppes','>No Information Currently Available','230000','0.824','9972','0','-0.05','0','1895.2','112.96928','214.0993795','3.1481','5.625','3.7268','59','72','61');
INSERT INTO provinces  VALUES ('Russia_Nenetsia','548,51','501,53','552,75',TRUE,'Naryan-Mar','Tundra','Nenetsia','Steppes','>No Information Currently Available','22000','0.824','9972','0','-0.1','0','181.28','97.28928','17.63660068','0.7638','4.8611','0.7175','57','62','57');
INSERT INTO provinces  VALUES ('Russia_Kirov','502,99','529,98','552,75',FALSE,'Kirov','Forest','Kirov','Steppes','>No Information Currently Available','470000','0.824','9972','0','0','0.1','3872.8','123.36928','477.7845476','4.5138','6.1342','5.2314','65','78','80');
INSERT INTO provinces  VALUES ('Russia_Perm','563,131','529,98','552,75',FALSE,'Perm','Plains','Perm Krai','Steppes','>No Information Currently Available','960000','0.824','9972','0','0','-0.2','7910.4','123.76928','979.0645125','6.5509','6.1574','6.6435','80','79','64');
INSERT INTO provinces  VALUES ('Russia_Aktau','563,131','586,134','555,144',FALSE,'Atyrau','Plains','Kazakhstan','Steppes','>No Information Currently Available','290000','0.824','9972','0','0','-0.2','2389.6','90.56928','216.4243515','3.7037','4.3287','3.75','61','64','49');
INSERT INTO provinces  VALUES ('Russia_Yugra','563,131','586,134','552,75',FALSE,'Khanty-Mansiysk','Plains','Yugra','Steppes','>No Information Currently Available','80000','0.824','9972','0','0','-0.2','659.2','118.96928','78.42454938','1.6203','5.8796','1.9212','57','77','46');
INSERT INTO provinces  VALUES ('Russia_WestYamalia','599,33','548,51','552,75',TRUE,'Salekhard','Tundra','Yamalia','Steppes','>No Information Currently Available','42000','0.824','9972','0','-0.1','0','346.08','106.48928','36.85381002','1.1111','5.324','1.3888','57','66','57');
INSERT INTO provinces  VALUES ('Russia_Samara','586,134','592,83','552,75',FALSE,'Samara','Taiga','Samara','Steppes','>No Information Currently Available','1100000','0.824','9972','0','-0.05','0','9064','88.16928','799.1663539','6.8981','4.2129','6.2037','81','60','79');
INSERT INTO provinces  VALUES ('Russia_EastYamalia','599,33','592,83','552,75',FALSE,'Surgut','Tundra','Yamalia','Steppes','>No Information Currently Available','450000','0.824','9972','0','-0.1','0','3708','114.16928','423.3396902','4.4212','5.6944','4.9074','65','68','69');
INSERT INTO provinces  VALUES ('Russia_NorthKrasoyarsk','599,33','592,83','648,30',TRUE,'Norilsk','Tundra','Krasoyarsk','Steppes','>No Information Currently Available','170000','0.824','9972','0','-0.1','0','1400.8','85.36928','119.5852874','2.5694','4.0972','2.5462','58','56','58');
INSERT INTO provinces  VALUES ('Russia_CentralKrasoyarsk','649,99','592,83','648,30',FALSE,'Krasoyarsk','Tundra','Krasoyarsk','Steppes','>No Information Currently Available','970000','0.824','9972','0','-0.1','0','7992.8','103.36928','826.2099812','6.574','5.1388','6.3194','80','64','79');
INSERT INTO provinces  VALUES ('Russia_SouthKrasoyarsk','649,99','592,83','646,141',FALSE,'Abakan','Taiga','Krasoyarsk','Steppes','>No Information Currently Available','160000','0.824','9972','0','-0.05','0','1318.4','105.76928','139.4462188','2.4768','5.2777','2.7314','58','69','58');
INSERT INTO provinces  VALUES ('Russia_Irkustk','649,99','726,120','646,141',FALSE,'Irkutsk','Taiga','Irkustk','Steppes','>No Information Currently Available','580000','0.824','9972','0','-0.05','0','4779.2','98.96928','472.993983','5.0694','4.9537','5.1851','71','66','72');
INSERT INTO provinces  VALUES ('Russia_SouthSakha','649,99','726,120','648,30',FALSE,'Yakutsk','Tundra','Sakha','Steppes','>No Information Currently Available','310000','0.824','9972','0','-0.1','0','2554.4','99.76928','254.8506488','3.8425','5','4.0509','61','63','62');
INSERT INTO provinces  VALUES ('Russia_NorthSakha','733,41','726,120','648,30',TRUE,'Tiksi','Tundra','Sakha','Steppes','>No Information Currently Available','5000','0.824','9972','0','-0.1','0','41.2','96.96928','3.995134336','0.3472','4.8379','0.2777','56','62','56');
INSERT INTO provinces  VALUES ('Russia_EastSakha','733,41','726,120','759,99',FALSE,'Mirny','Taiga','Sakha','Steppes','>No Information Currently Available','37000','0.824','9972','0','-0.05','0','304.88','91.68928','27.95422769','1.0879','4.4212','1.1574','57','62','57');
INSERT INTO provinces  VALUES ('Russia_Khabarovsk','759,99','726,120','786,125',TRUE,'Komsomolsk-on-Amur','Taiga','Khabarovsk Krai','Steppes','>No Information Currently Available','260000','0.824','9972','0','-0.05','0','2142.4','101.76928','218.0305055','3.4259','5.0231','3.8194','60','67','61');
INSERT INTO provinces  VALUES ('Russia_Magadan','733,41','791,86','759,99',TRUE,'Magadan','Taiga','Magadan','Steppes','>No Information Currently Available','95000','0.824','9972','0','-0.05','0','782.8','113.36928','88.74547238','1.7824','5.6712','2.1064','57','72','58');
INSERT INTO provinces  VALUES ('Russia_Chukotka','733,41','791,86','851,62',TRUE,'Anadyr','Tundra','Chukotka','Steppes','>No Information Currently Available','13000','0.824','9972','0','-0.1','0','107.12','120.64928','12.92395087','0.5555','5.9953','0.5787','57','70','57');
INSERT INTO provinces  VALUES ('Russia_Kamchatka','815,114','791,86','851,62',TRUE,'Petropavlovsk-Kamchatsky','Tundra','Kamchatka','Steppes','>No Information Currently Available','180000','0.824','9972','0','-0.1','0','1483.2','114.96928','170.5224361','2.7083','5.7175','3.1944','58','69','59');
INSERT INTO provinces  VALUES ('CentralAsia_Kazakhstan','586,134','592,83','646,141',FALSE,'Nur-Sultan','Plains','Kazakhstan','Steppes','>No Information Currently Available','1100000','0.825','8782','0','0','-0.2','9075','97.4515','884.3723625','6.9212','4.8842','6.4351','81','69','64');
INSERT INTO provinces  VALUES ('CentralAsia_KazakhstanMangystau','586,134','567,157','555,144',FALSE,'Aktau','Plains','Kazakhstan','Steppes','>No Information Currently Available','190000','0.825','8782','0','0','-0.2','1567.5','104.9515','164.5114763','2.8009','5.2314','3.1018','59','72','47');
INSERT INTO provinces  VALUES ('CentralAsia_Mongolia','717,162','726,120','646,141',FALSE,'Ulaanbaatar','Plains','Mongolia','Steppes','>No Information Currently Available','1400000','0.737','3990','0','0','-0.2','10318','49.4063','509.7742034','7.1296','2.5462','5.3935','81','58','59');
INSERT INTO provinces  VALUES ('CentralAsia_SouthAfghanistan','588,202','608,183','579,181',FALSE,'Kandahar','Plains','Afghanistan','Steppes','>No Information Currently Available','610000','0.511','499','0','0','-0.2','3117.1','18.04989','56.26331212','4.1203','0.625','1.6435','63','57','46');
INSERT INTO provinces  VALUES ('CentralAsia_NorthAfghanistan','633,172','608,183','579,181',FALSE,'Kabul','Plains','Afghanistan','Steppes','>No Information Currently Available','4400000','0.511','499','0','0','-0.2','22484','22.54989','507.0117268','8.3796','0.7638','5.3472','83','57','59');
INSERT INTO provinces  VALUES ('CentralAsia_Turkmenistan','567,157','562,173','579,181',FALSE,'Ashgabat','Plains','Turkmenistan','Steppes','>No Information Currently Available','1000000','0.715','7507','0','0','-0.2','7150','53.67505','383.7766075','6.2962','2.8009','4.6759','79','59','53');
INSERT INTO provinces  VALUES ('CentralAsia_NorthTurkmenistan','567,157','596,158','579,181',FALSE,'Dasoguz','Plains','Turkmenistan','Steppes','>No Information Currently Available','210000','0.715','7507','0','0','-0.2','1501.5','95.17505','142.9053376','2.7314','4.7453','2.824','58','68','47');
INSERT INTO provinces  VALUES ('CentralAsia_Uzbekistan','586,134','567,157','596,158',FALSE,'Tashkent','Plains','Uzbekistan','Steppes','>No Information Currently Available','2500000','0.72','1763','0','0','-0.2','18000','12.6936','228.4848','8.1944','0.4166','3.912','83','56','49');
INSERT INTO provinces  VALUES ('CentralAsia_Tajikistan','579,181','633,172','596,158',FALSE,'Dushanbe','Plains','Tajikistan','Steppes','>No Information Currently Available','860000','0.668','834','0','0','-0.2','5744.8','30.37112','174.4760102','5.7407','1.3194','3.2638','76','57','48');
INSERT INTO provinces  VALUES ('CentralAsia_Kyrgyzstan','586,134','646,141','596,158',FALSE,'Bishkek','Plains','Kyrgyzstan','Steppes','>No Information Currently Available','1000000','0.697','1148','0','0','-0.2','6970','48.00156','334.5708732','6.25','2.2916','4.4444','79','58','52');
INSERT INTO provinces  VALUES ('China_Jilin','726,120','786,125','770,156',TRUE,'Changchun','Forest','Jilin','China Sea','>No Information Currently Available','7700000','0.761','10839','0','0','0.1','58597','125.48479','7353.03224','9.2592','6.2037','9.3055','83','79','92');
INSERT INTO provinces  VALUES ('China_Liaoning','726,120','770,156','746,159',FALSE,'Shenyang','Forest','Liaoning','China Sea','>No Information Currently Available','8200000','0.761','10839','0','0','0.1','62402','120.48479','7518.491866','9.3287','5.9722','9.3287','83','78','92');
INSERT INTO provinces  VALUES ('China_NorthInnerMongolia','726,120','717,162','746,159',FALSE,'Harbin','Forest','Heilongjiang','China Sea','>No Information Currently Available','10000000','0.761','10839','0','0','0.1','76100','82.48479','6277.092519','9.6064','3.9814','9.1203','84','62','92');
INSERT INTO provinces  VALUES ('China_Beijing','753,175','717,162','746,159',TRUE,'Beijing','Forest','Beijing','China Sea','The city of Beijing is the capital of the Peoples Republic of China, and the historical head of the Chinese Empire, as well as the location of the Forbidden City. Though razed many times, the site of Beijing has been important throughout Chinese history, being named the capital of its region by the first Emperor of china, Qin Shi Huang. The modern city of Beijing is an important cultural and economic capital, and is home to the most billionaires in the world [Shapiro].','22000000','0.761','10839','0.6','0','0.1','167420','112.48479','18832.20354','9.9768','5.5324','9.8611','134','75','92');
INSERT INTO provinces  VALUES ('China_Shandong','753,175','717,162','732,189',FALSE,'Jinan','Forest','Shandong','China Sea','(Confucian Holy site - Kong family mansion)','8700000','0.761','10839','0.4','0','0.1','66207','115.48479','7645.901492','9.4444','5.7407','9.3518','117','76','92');
INSERT INTO provinces  VALUES ('China_Jiangsu','753,175','765,201','732,189',TRUE,'Nanjing','Forest','Jiangsu','China Sea','>No Information Currently Available','8500000','0.761','10839','0','0','0.1','64685','97.48479','6305.803641','9.3981','4.9074','9.1435','83','69','92');
INSERT INTO provinces  VALUES ('China_Zhejiang','762,211','765,201','732,189',TRUE,'Hangzhou','Forest','Zhejiang','China Sea','>No Information Currently Available','10300000','0.761','10839','0','0','0.1','78383','109.48479','8581.746295','9.6527','5.4166','9.4907','84','74','92');
INSERT INTO provinces  VALUES ('China_Fujian','762,211','752,226','743,220',TRUE,'Fuzhou','Forest','Fujian','China Sea','>No Information Currently Available','4600000','0.761','10839','0','0','0.1','35006','96.48479','3377.546559','8.7962','4.7916','8.3564','83','68','91');
INSERT INTO provinces  VALUES ('China_EastGuangdong','738,235','752,226','743,220',TRUE,'Guangzhou','Forest','Guandong','China Sea','>No Information Currently Available','15000000','0.761','10839','0','0','0.1','114150','82.48479','9415.638779','9.8842','3.9814','9.5601','84','62','92');
INSERT INTO provinces  VALUES ('China_WestGuangdong','738,235','729,231','743,220',TRUE,'Shenzhen','Forest','Guandong','China Sea','>No Information Currently Available','12000000','0.761','10839','0','0','0.1','91320','112.48479','10272.11102','9.8148','5.5324','9.6296','84','75','92');
INSERT INTO provinces  VALUES ('China_Jiangxi','741,209','762,211','743,220',FALSE,'Nanchang','Forest','Jiangxi','China Sea','(Holy site - Taoist sacred mountain)','5000000','0.761','10839','0.2','0','0.1','38050','82.48479','3138.54626','8.8657','3.9814','8.1712','100','62','91');
INSERT INTO provinces  VALUES ('China_Anhui','741,209','762,211','732,189',FALSE,'Hefei','Forest','Anhui','China Sea','(Holy site - Taoist sacred mountain)','7900000','0.761','10839','0.2','0','0.1','60119','93.48479','5620.21209','9.2824','4.6527','9.0509','100','67','92');
INSERT INTO provinces  VALUES ('China_NorthHeinan','710,187','718,199','732,189',FALSE,'Haikou','Forest','Hainan','China Sea','>No Information Currently Available','2000000','0.761','10839','0','0','0.1','15220','112.48479','1712.018504','7.8472','5.5324','7.4305','82','75','90');
INSERT INTO provinces  VALUES ('China_SouthHeinan','741,209','718,199','732,189',FALSE,'Sanya','Forest','Hainan','China Sea','>No Information Currently Available','680000','0.761','10839','0','0','0.1','5174.8','83.68479','433.0520513','5.3009','4.0509','4.9537','73','62','76');
INSERT INTO provinces  VALUES ('China_Hubei','741,209','718,199','720,218',FALSE,'Wuhan','Forest','Hubei','China Sea','(Holy site - Taoist sacred mountain)','11000000','0.761','10839','0.2','0','0.1','83710','122.48479','10253.20177','9.7453','6.0648','9.5833','100','78','92');
INSERT INTO provinces  VALUES ('China_Hunan','741,209','743,220','720,218',FALSE,'Changsha','Forest','Hunan','China Sea','>No Information Currently Available','8100000','0.761','10839','0','0','0.1','61641','111.48479','6872.03394','9.3055','5.4629','9.2361','83','74','92');
INSERT INTO provinces  VALUES ('China_Heibei','717,162','732,189','710,187',FALSE,'Shijiazhuang','Forest','Heibei','China Sea','>No Information Currently Available','11000000','0.761','10839','0','0','0.1','83710','122.48479','10253.20177','9.7453','6.0648','9.5833','84','78','92');
INSERT INTO provinces  VALUES ('China_EastGuangxi','729,231','743,220','720,218',FALSE,'Nanning','Savanna','Guangxi','China Sea','>No Information Currently Available','7200000','0.761','10839','0','0','0','54792','130.48479','7149.522614','9.1666','6.3657','9.2824','83','79','83');
INSERT INTO provinces  VALUES ('China_WestGuangxi','729,231','698,232','720,218',FALSE,'Liuzhou','Savanna','Guangxi','China Sea','>No Information Currently Available','3700000','0.761','10839','0','0','0','28157','115.48479','3251.705232','8.6342','5.7407','8.2175','83','76','83');
INSERT INTO provinces  VALUES ('China_Yunnan','698,232','673,206','674,229',FALSE,'Kunming','Savanna','Yunnan','China Sea','>No Information Currently Available','6600000','0.761','10839','0','0','0','50226','126.48479','6352.825063','9.0972','6.25','9.1666','83','79','83');
INSERT INTO provinces  VALUES ('China_Guizhou','698,232','673,206','720,218',FALSE,'Guiyang','Savanna','Guizhou','China Sea','>No Information Currently Available','4600000','0.761','10839','0','0','0','35006','96.48479','3377.546559','8.7962','4.7916','8.3564','83','68','83');
INSERT INTO provinces  VALUES ('China_SouthChongqing','718,199','673,206','720,218',FALSE,'Yuzhong','Savanna','Chongqing','China Sea','>No Information Currently Available','630000','0.761','10839','0','0','0','4794.3','129.18479','619.3506387','5.0925','6.2731','5.7175','71','79','76');
INSERT INTO provinces  VALUES ('China_NorthChongqing','718,199','673,206','710,187',FALSE,'Jiangbei','Savanna','Chongqing','China Sea','>No Information Currently Available','230000','0.761','10839','0','0','0','1750.3','93.18479','163.1013379','2.9629','4.5833','3.0787','59','66','59');
INSERT INTO provinces  VALUES ('China_Shaanxi','693,178','673,206','710,187',FALSE,'Xian','Savanna','Shaanxi','China Sea','>No Information Currently Available','12000000','0.761','10839','0','0','0','91320','112.48479','10272.11102','9.8148','5.5324','9.6296','84','75','84');
INSERT INTO provinces  VALUES ('China_Shanxi','693,178','717,162','710,187',FALSE,'Taiyuan','Forest','Shanxi','China Sea','>No Information Currently Available','4200000','0.761','10839','0','0','0.1','31962','110.48479','3531.314858','8.75','5.4398','8.4722','83','74','91');
INSERT INTO provinces  VALUES ('China_SouthInnerMongolia','693,178','717,162','646,141',FALSE,'Wuhai','Plains','Inner Mongolia','China Sea','>No Information Currently Available','630000','0.761','10839','0','0','-0.2','4794.3','129.18479','619.3506387','5.0925','6.2731','5.7175','71','79','61');
INSERT INTO provinces  VALUES ('China_EastQinghai','693,178','673,206','646,141',FALSE,'Lanzhou','Plains','Gansu','China Sea','>No Information Currently Available','3700000','0.761','10839','0','0','-0.2','28157','115.48479','3251.705232','8.6342','5.7407','8.2175','83','76','66');
INSERT INTO provinces  VALUES ('China_WestQinghai','673,206','649,185','646,141',FALSE,'Xining','Plains','Qinghai','China Sea','>No Information Currently Available','2200000','0.761','10839','0','0','-0.2','16742','130.48479','2184.576354','8.0787','6.3657','7.7777','83','79','66');
INSERT INTO provinces  VALUES ('China_SouthTibet','673,206','632,200','649,185',FALSE,'Thimphu','Plains','Bhutan','China Sea','>No Information Currently Available','110000','0.761','10839','0','0','-0.2','837.1','122.38479','102.4483077','1.9212','6.0416','2.2685','57','78','46');
INSERT INTO provinces  VALUES ('China_CentralTibet','633,172','632,200','608,183',FALSE,'Lhasa','Plains','Tibet','China Sea','(Potala Palace)','600000','0.761','10839','0.2','0','-0.2','4566','86.48479','394.8895511','4.9537','4.1203','4.699','83','63','54');
INSERT INTO provinces  VALUES ('China_WestTibet','633,172','632,200','649,185',FALSE,'Shigatse','Plains','Tibet','China Sea','>No Information Currently Available','700000','0.761','10839','0','0','-0.2','5327','95.48479','508.6474763','5.4861','4.7685','5.3703','75','68','59');
INSERT INTO provinces  VALUES ('China_EastXinjiang','633,172','649,185','646,141',FALSE,'Hami','Plains','Xinjiang','China Sea','>No Information Currently Available','580000','0.761','10839','0','0','-0.2','4413.8','124.68479','550.3337261','4.8148','6.1805','5.5092','68','79','60');
INSERT INTO provinces  VALUES ('China_WestXinjiang','633,172','596,158','646,141',FALSE,'Urumqi','Plains','Xinjiang','China Sea','>No Information Currently Available','3500000','0.761','10839','0','0','-0.2','26635','97.48479','2596.507382','8.5648','4.9074','7.9398','83','69','66');
INSERT INTO provinces  VALUES ('EastAsia_NorthKorea','769,169','770,156','746,159',TRUE,'Pyongyang','Forest','Korea','China Sea','>No Information Currently Available','2800000','0.766','640','0','0','0.1','21448','14.9024','319.6266752','8.3101','0.5324','4.375','83','56','71');
INSERT INTO provinces  VALUES ('EastAsia_EastKorea','769,169','770,156','780,177',TRUE,'Sokcho','Forest','Korea','China Sea','>No Information Currently Available','89000','0.916','30644','0','0','0.1','815.24','319.53904','260.501007','1.8055','7.2222','4.1203','57','81','69');
INSERT INTO provinces  VALUES ('EastAsia_SouthKorea','769,169','780,177','773,181',TRUE,'Seoul','Forest','Korea','China Sea','>No Information Currently Available','9700000','0.916','30644','0','0','0.1','88852','312.69904','27783.9351','9.7916','7.1759','9.9074','84','81','92');
INSERT INTO provinces  VALUES ('EastAsia_JapanHokkaido','797,138','802,155','811,146',TRUE,'Sapporo','Forest','Hokkaido','China Sea','>No Information Currently Available','1900000','0.919','39048','0','0','0.1','17461','370.85112','6475.431406','8.1481','7.3611','9.1898','83','82','92');
INSERT INTO provinces  VALUES ('EastAsia_JapanTohoku','812,178','802,155','803,166',TRUE,'Fukushima','Forest','Tohoku','China Sea','>No Information Currently Available','280000','0.919','39048','0','0','0.1','2573.2','403.25112','1037.645782','3.8657','7.7777','6.8518','62','82','89');
INSERT INTO provinces  VALUES ('EastAsia_JapanChubu','812,178','802,181','803,166',TRUE,'Nagoya','Forest','Chubu','China Sea','>No Information Currently Available','2300000','0.919','39048','0','0','0.1','21137','362.85112','7669.584123','8.287','7.2916','9.375','83','82','92');
INSERT INTO provinces  VALUES ('EastAsia_JapanKansai','788,178','802,181','803,166',TRUE,'Tokyo','Forest','Kanto','China Sea','>No Information Currently Available','14000000','0.919','39048','0','0','0.1','128660','378.85112','48742.9851','9.9537','7.4537','9.9768','84','82','92');
INSERT INTO provinces  VALUES ('EastAsia_JapanKyushu','788,178','802,181','785,187',TRUE,'Dazaifu','Forest','Kyushu','China Sea','>No Information Currently Available','72000','0.919','39048','0','0','0.1','661.68','397.41112','262.9589899','1.6666','7.7083','4.1666','57','82','69');
INSERT INTO provinces  VALUES ('India_Bangladesh','674,229','659,215','673,206',FALSE,'Dhaka','Savanna','Bangladesh','Indian','>No Information Currently Available','8900000','0.632','1888','0','0','0','56248','27.93216','1571.128136','9.1898','1.1805','7.2685','83','57','82');
INSERT INTO provinces  VALUES ('India_Nepal','632,200','659,215','673,206',FALSE,'Kathmandu','Savanna','Nepal','Indian','(Holy site - birthplace of prince siddhartha gautama)','1400000','0.602','1116','0.4','0','0','8428','8.71832','73.47800096','6.7361','0.162','1.875','113','56','57');
INSERT INTO provinces  VALUES ('India_Odisha','674,229','659,215','656,246',TRUE,'Bhubaneswar','Savanna','Odisha','Indian','>No Information Currently Available','830000','0.645','1877','0','0','0','5353.5','19.60665','104.9642008','5.5092','0.6481','2.3379','75','57','58');
INSERT INTO provinces  VALUES ('India_AndhraPradesh','651,264','642,259','656,246',TRUE,'Amaravati','Savanna','Andhra Pradesh','Indian','>No Information Currently Available','100000','0.645','1877','0','0','0','645','37.10665','23.93378925','1.574','1.8055','0.9953','57','57','57');
INSERT INTO provinces  VALUES ('India_TamilNadu','651,264','642,259','643,282',TRUE,'Chennai','Savanna','Tamil Nadu','Indian','>No Information Currently Available','7000000','0.645','1877','0','0','0','45150','12.10665','546.6152475','9.0277','0.324','5.4861','83','56','75');
INSERT INTO provinces  VALUES ('India_Kerala','630,256','642,259','643,282',TRUE,'Thiruvananthapuram','Jungle','Kerala','Indian','>No Information Currently Available','750000','0.645','1877','0','0','0.1','4837.5','49.60665','239.9721694','5.162','2.5694','3.9814','72','58','68');
INSERT INTO provinces  VALUES ('India_Telangana','630,256','642,259','656,246',FALSE,'Hyderabad','Savanna','Telangana','Indian','>No Information Currently Available','6800000','0.645','1877','0','0','0','43860','12.10665','530.997669','8.9814','0.324','5.4629','83','56','74');
INSERT INTO provinces  VALUES ('India_Maharashtra','630,256','625,241','656,246',TRUE,'Mumbai','Savanna','Maharashtra','Indian','>No Information Currently Available','12000000','0.645','1877','0','0','0','77400','12.10665','937.05471','9.6296','0.324','6.5046','84','56','80');
INSERT INTO provinces  VALUES ('India_MadhyaPradesh','645,226','625,241','656,246',FALSE,'Bhopal','Savanna','Madhya Pradesh','Indian','>No Information Currently Available','1700000','0.645','1877','0','0','0','10965','37.10665','406.8744173','7.2222','1.8055','4.7685','81','57','68');
INSERT INTO provinces  VALUES ('India_Chhattisgarh','645,226','659,215','656,246',FALSE,'Naya Raipur','Savanna','Chhattisgarh','Indian','>No Information Currently Available','560000','0.645','1877','0','0','0','3612','52.10665','188.2092198','4.3518','2.7314','3.4953','64','58','60');
INSERT INTO provinces  VALUES ('India_UttarPradesh','645,226','659,215','632,200',FALSE,'Lucknow','Savanna','Uttar Pradesh','Indian','(Holy site - Various hindu holy sites)','3500000','0.645','1877','0.5','0','0','22575','37.10665','837.6826238','8.4027','1.8055','6.3657','124','57','79');
INSERT INTO provinces  VALUES ('India_Gujarat','645,226','625,241','613,225',TRUE,'Gandhinagar','Savanna','Gujarat','Indian','(Holy site - Jain holy mountain of shatrunjaya)','290000','0.645','1877','0.6','0','0','1870.5','34.60665','64.73173883','3.0787','1.5509','1.7592','95','57','57');
INSERT INTO provinces  VALUES ('India_Rajasthan','645,226','632,200','613,225',FALSE,'New Delhi','Savanna','Delhi','Indian','>No Information Currently Available','250000','0.645','1877','0','0','0','1612.5','24.60665','39.67822313','2.824','0.949','1.4351','59','57','57');
INSERT INTO provinces  VALUES ('India_PakistanBaluchistan','599,216','588,202','608,183',FALSE,'Quetta','Savanna','Baluchistan','Indian','>No Information Currently Available','1000000','0.557','1285','0','0','0','5570','27.15745','151.2669965','5.6481','1.1111','2.8935','76','57','59');
INSERT INTO provinces  VALUES ('India_PakistanMakran','599,216','588,202','581,216',TRUE,'Chabahar','Savanna','Makran','Indian','>No Information Currently Available','100000','0.557','1285','0','0','0','557','54.15745','30.16569965','1.412','2.824','1.2037','57','59','57');
INSERT INTO provinces  VALUES ('India_PakistanPunjab','599,216','632,200','608,183',FALSE,'Islamabad','Savanna','Punjab','Indian','(Holy site - Sikh temple of god)','1000000','0.557','1285','0.3','0','0','5570','27.15745','151.2669965','5.6481','1.1111','2.8935','98','57','59');
INSERT INTO provinces  VALUES ('India_PakistanSindh','599,216','632,200','613,225',TRUE,'Karachi','Savanna','Sindh','Indian','>No Information Currently Available','15000000','0.557','1285','0','0','0','83550','57.15745','4775.504947','9.7222','2.9398','8.9583','84','59','83');
INSERT INTO provinces  VALUES ('India_SriLanka','656,280','651,287','660,289',TRUE,'Kotte','Jungle','Sri Lanka','Indian','>No Information Currently Available','110000','0.782','3698','0','0','0.1','860.2','33.51836','28.83249327','2.037','1.5046','1.1805','58','57','63');
INSERT INTO provinces  VALUES ('SEAsia_BurmaNorth','698,232','692,254','674,229',TRUE,'Mandalay','Jungle','North Burma','South East Asia','>No Information Currently Available','1700000','0.578','1407','0','0','0.1','9826','10.13246','99.56155196','7.0601','0.1851','2.2222','81','56','64');
INSERT INTO provinces  VALUES ('SEAsia_BurmaSouth','698,232','692,254','706,262',TRUE,'Naypyidaw','Jungle','South Burma','South East Asia','>No Information Currently Available','920000','0.578','1407','0','0','0.1','5317.6','13.33246','70.8966893','5.4629','0.4398','1.8055','74','56','63');
INSERT INTO provinces  VALUES ('SEAsia_ThailandCentral','721,271','715,241','706,262',TRUE,'Pattaya','Jungle','Thailand','South East Asia','>No Information Currently Available','110000','0.777','7295','0','0','0.1','854.7','105.08215','89.8137136','2.0138','5.2546','2.1527','58','72','63');
INSERT INTO provinces  VALUES ('SEAsia_ThailandNorth','698,232','715,241','706,262',FALSE,'Bangkok','Jungle','Thailand','South East Asia','>No Information Currently Available','8300000','0.777','7295','0','0','0.1','64491','58.68215','3784.470536','9.375','2.9861','8.6342','83','59','91');
INSERT INTO provinces  VALUES ('SEAsia_ThailandGulf','707,262','705,284','710,278',TRUE,'Ranong','Jungle','Thailand','South East Asia','>No Information Currently Available','16000','0.777','7295','0','0','0.1','124.32','93.72215','11.65153769','0.625','4.6759','0.4861','57','67','62');
INSERT INTO provinces  VALUES ('SEAsia_ThailandSouth','705,284','710,278','720,292',TRUE,'Hat Yai','Jungle','Thailand','South East Asia','>No Information Currently Available','150000','0.777','7295','0','0','0.1','1165.5','72.68215','84.71104583','2.3611','3.5648','2.037','58','60','63');
INSERT INTO provinces  VALUES ('SEAsia_Laos','698,232','715,241','729,231',FALSE,'Vientiane','Savanna','Laos','South East Asia','>No Information Currently Available','940000','0.613','2567','0','0','0','5762.2','27.13571','156.3613882','5.7638','1.0879','2.9861','77','57','59');
INSERT INTO provinces  VALUES ('SEAsia_Cambodia','730,249','715,241','721,271',FALSE,'Phnom Penh','Savanna','Cambodia','South East Asia','>No Information Currently Available','2200000','0.594','1572','0','0','0','13068','35.33768','461.7928022','7.5462','1.6898','5.1157','82','57','71');
INSERT INTO provinces  VALUES ('SEAsia_VietnamNorth','730,249','715,241','729,231',TRUE,'Hanoi','Jungle','Vietnam','South East Asia','>No Information Currently Available','8000000','0.704','3498','0','0','0.1','56320','34.62592','1950.131814','9.2129','1.574','7.5925','83','57','90');
INSERT INTO provinces  VALUES ('SEAsia_VietnamCentral','730,249','721,272','739,272',TRUE,'Hue','Jungle','Vietnam','South East Asia','>No Information Currently Available','450000','0.704','3498','0','0','0.1','3168','68.62592','217.4069146','4.1666','3.4259','3.7962','63','60','67');
INSERT INTO provinces  VALUES ('SEAsia_VietnamSouth','727,282','721,272','739,272',TRUE,'Ho Chi Minh City ','Jungle','Vietnam','South East Asia','>No Information Currently Available','9000000','0.704','3498','0','0','0.1','63360','54.62592','3461.098291','9.3518','2.8703','8.449','83','59','91');
INSERT INTO provinces  VALUES ('SEAsia_Malaysia','705,284','722,308','720,292',TRUE,'Kuala Lumpur','Jungle','Malaysia','South East Asia','>No Information Currently Available','1800000','0.81','10192','0','0','0.1','14580','92.5552','1349.454816','7.7083','4.5138','7.1064','82','65','89');
INSERT INTO provinces  VALUES ('SEAsia_IndonesiaSumatraNorth','698,293','713,322','725,315',TRUE,'Medan','Jungle','Sumatra','South East Asia','>No Information Currently Available','2200000','0.718','4038','0','0','0.1','15796','34.99284','552.7469006','7.9629','1.6435','5.5555','82','57','83');
INSERT INTO provinces  VALUES ('SEAsia_IndonesiaSumatraSouth','729,338','713,322','725,315',TRUE,'Palembang','Jungle','Sumatra','South East Asia','>No Information Currently Available','1800000','0.718','4038','0','0','0.1','12924','42.99284','555.6394642','7.5231','2.2222','5.625','82','58','83');
INSERT INTO provinces  VALUES ('SEAsia_IndonesiaJavaWest','733,343','748,340','759,350',TRUE,'Jakarta','Jungle','Java','South East Asia','>No Information Currently Available','10000000','0.718','4038','0','0','0.1','71800','28.99284','2081.685912','9.537','1.2268','7.7083','84','57','90');
INSERT INTO provinces  VALUES ('SEAsia_IndonesiaJavaEast','780,351','748,340','759,350',TRUE,'Surabaya','Jungle','Java','South East Asia','>No Information Currently Available','2800000','0.718','4038','0','0','0.1','20104','72.99284','1467.448055','8.2407','3.5879','7.2222','83','60','90');
INSERT INTO provinces  VALUES ('SEAsia_IndonesiaKalimantanWest','739,311','754,313','744,328',TRUE,'Pontianak','Jungle','Borneo','South East Asia','>No Information Currently Available','660000','0.718','4038','0','0','0.1','4738.8','35.79284','169.6151102','5.0462','1.7129','3.1481','70','57','65');
INSERT INTO provinces  VALUES ('SEAsia_IndonesiaKalimantanCentral','762,330','754,313','744,328',TRUE,'Palangkaraya','Jungle','Borneo','South East Asia','>No Information Currently Available','270000','0.718','4038','0','0','0.1','1938.6','63.59284','123.2810796','3.2175','3.1944','2.6157','59','59','64');
INSERT INTO provinces  VALUES ('SEAsia_IndonesiaKalimantanEast','762,330','754,313','766,300',TRUE,'Balikpapan','Jungle','Borneo','South East Asia','>No Information Currently Available','850000','0.718','4038','0','0','0.1','6103','61.99284','378.3423025','5.8564','3.125','4.6064','77','59','73');
INSERT INTO provinces  VALUES ('SEAsia_IndonesiaKalimantanNorth','739,311','754,313','766,300',FALSE,'Tarakan','Jungle','Borneo','South East Asia','>No Information Currently Available','270000','0.718','4038','0','0','0.1','1938.6','63.59284','123.2810796','3.2175','3.1944','2.6157','59','59','64');
INSERT INTO provinces  VALUES ('SEAsia_IndonesiaSulawesi','771,337','777,309','782,335',TRUE,'Makassar','Jungle','Sulawesi','South East Asia','>No Information Currently Available','1500000','0.718','4038','0','0','0.1','10770','48.99284','527.6528868','7.1759','2.3379','5.4398','81','58','82');
INSERT INTO provinces  VALUES ('SEAsia_IndonesiaPapauWest','805,319','835,324','828,337',TRUE,'Sorong','Jungle','New Guinea','South East Asia','>No Information Currently Available','250000','0.718','4038','0','0','0.1','1795','73.99284','132.8171478','2.9861','3.6574','2.6851','59','61','64');
INSERT INTO provinces  VALUES ('SEAsia_IndonesiaPapauEast','838,352','835,324','828,337',TRUE,'Jayapura','Jungle','New Guinea','South East Asia','>No Information Currently Available','310000','0.718','4038','0','0','0.1','2225.8','42.79284','95.24830327','3.5416','2.199','2.1759','60','58','63');
INSERT INTO provinces  VALUES ('SEAsia_PapauNewGuinea','838,352','835,324','865,356',TRUE,'Port Moresby','Jungle','New Guinea','South East Asia','>No Information Currently Available','360000','0.555','2652','0','0','0.1','1998','24.7186','49.3877628','3.3101','0.9722','1.5277','60','57','63');
INSERT INTO provinces  VALUES ('SEAsia_PhillipinesManila','770,242','772,260','784,262',TRUE,'Manila','Jungle','Phillipines','South East Asia','>No Information Currently Available','1700000','0.718','3373','0','0','0.1','12206','40.21814','490.9026168','7.4768','2.0138','5.2777','82','58','80');
INSERT INTO provinces  VALUES ('SEAsia_PhillipinesDavao','787,280','796,273','801,283',TRUE,'Davao City','Jungle','Phillipines','South East Asia','>No Information Currently Available','1600000','0.718','3373','0','0','0.1','11488','42.21814','485.0019923','7.3148','2.1527','5.2546','82','58','80');
INSERT INTO provinces  VALUES ('SEAsia_Brunei','739,311','763,288','766,300',TRUE,'Bandar Seri Begawan','Jungle','Borneo','South East Asia','>No Information Currently Available','100000','0.838','23117','0','0','0.1','838','221.72046','185.8017455','1.9444','6.8981','3.4259','57','81','66');
INSERT INTO provinces  VALUES ('Australia_QueenslandNorth','830,382','838,359','862,416',TRUE,'Cairns','Plains','Queensland','South East Asia','>No Information Currently Available','150000','0.944','51885','0','0','-0.2','1416','509.7944','721.8688704','2.6157','8.7731','5.9722','58','83','62');
INSERT INTO provinces  VALUES ('Australia_QueenslandSouth','830,382','827,413','862,416',FALSE,'Brisbane','Plains','Queensland','South East Asia','>No Information Currently Available','2200000','0.944','51885','0','0','-0.2','20768','499.7944','10379.7301','8.2638','8.6342','9.6759','83','83','67');
INSERT INTO provinces  VALUES ('Australia_NewSouthWales','846,446','827,413','862,416',TRUE,'Canberra','Plains','New South Wales','South East Asia','>No Information Currently Available','390000','0.944','51885','0','0','-0.2','3681.6','521.7944','1921.038263','4.375','8.9814','7.5694','64','83','66');
INSERT INTO provinces  VALUES ('Australia_Victoria','846,446','798,444','812,468',TRUE,'Melbourne','Plains','Victoria','South East Asia','>No Information Currently Available','4900000','0.944','51885','0','0','-0.2','46256','509.7944','23581.04977','9.074','8.7731','9.8842','83','83','67');
INSERT INTO provinces  VALUES ('Australia_SouthAustraliaEast','846,446','798,444','827,413',FALSE,'Midura','Plains','New South Wales','South East Asia','>No Information Currently Available','30000','0.944','51885','0','0','-0.2','283.2','503.7944','142.6745741','0.9722','8.6574','2.7777','57','83','47');
INSERT INTO provinces  VALUES ('Australia_SouthAustraliaCentral','775,415','798,444','827,413',FALSE,'Adelaide','Plains','South Australia','South East Asia','>No Information Currently Available','1300000','0.944','51885','0','0','-0.2','12272','529.7944','6501.636877','7.5','9.0972','9.2129','82','83','67');
INSERT INTO provinces  VALUES ('Australia_SouthAustraliaWest','775,415','798,444','769,441',TRUE,'Port Lincoln','Plains','South Australia','South East Asia','>No Information Currently Available','16000','0.944','51885','0','0','-0.2','151.04','530.5944','80.14097818','0.6712','9.1203','1.9675','57','83','46');
INSERT INTO provinces  VALUES ('Australia_WesternAustraliaSouth','748,455','744,440','769,441',TRUE,'Albany','Plains','Western Australia','South East Asia','>No Information Currently Available','97000','0.944','51885','0','0','-0.2','915.68','493.3944','451.7913842','2.1064','8.5185','5.0925','58','83','57');
INSERT INTO provinces  VALUES ('Australia_WesternAustraliaWest','745,400','744,440','769,441',TRUE,'Perth','Plains','Western Australia','South East Asia','>No Information Currently Available','1900000','0.944','51885','0','0','-0.2','17936','509.7944','9143.672358','8.1712','8.7731','9.537','83','83','67');
INSERT INTO provinces  VALUES ('Australia_WesternAustraliaCentral','745,400','775,415','769,441',FALSE,'Wiluna','Desert','Western Australia','South East Asia','>No Information Currently Available','1600','0.944','51885','0','0','0','15.104','503.8744','7.610518938','0.162','8.6805','0.4398','56','83','56');
INSERT INTO provinces  VALUES ('Australia_WesternAustraliaNorth','745,400','775,415','791,369',TRUE,'Newman','Desert','Western Australia','South East Asia','>No Information Currently Available','6700','0.944','51885','0','0','0','63.248','498.7544','31.54521829','0.4629','8.6111','1.2731','56','83','57');
INSERT INTO provinces  VALUES ('Australia_AliceSprings','827,413','775,415','830,382',FALSE,'Alice Springs','Desert','Alice Springs','South East Asia','>No Information Currently Available','25000','0.944','51885','0','0','0','236','509.7944','120.3114784','0.9027','8.7731','2.5694','57','83','58');
INSERT INTO provinces  VALUES ('Australia_NorthernAustraliaSouth','791,369','775,415','830,382',FALSE,'Kintore','Desert','North Australia','South East Asia','>No Information Currently Available','410','0.944','51885','0','0','0','3.8704','493.4024','1.909664649','0.0462','8.5416','0.0925','56','83','56');
INSERT INTO provinces  VALUES ('Australia_NorthernAustraliaNorth','791,369','807,359','830,382',TRUE,'Darwin','Plains','North Australia','South East Asia','>No Information Currently Available','140000','0.944','51885','0','0','-0.2','1321.6','521.7944','689.603479','2.5','8.9814','5.8796','58','83','62');
INSERT INTO provinces  VALUES ('Australia_NewZealandWellington','895,453','917,460','906,473',TRUE,'Auckland','Forest','North island','South East Asia','>No Information Currently Available','1600000','0.931','38675','0','0','0.1','14896','388.06425','5780.605068','7.7314','7.5462','9.074','82','82','92');
INSERT INTO provinces  VALUES ('Australia_NewZealandWestcoast','904,476','893,470','876,482',TRUE,'Wellington','Forest','Wellington','South East Asia','[True capital of new zealand]','210000','0.931','38675','0','0','0.1','1955.1','364.36425','712.3685452','3.2638','7.3148','5.949','60','82','85');
INSERT INTO provinces  VALUES ('Australia_NewZealandCanterbury','904,476','874,495','876,482',TRUE,'Christchurch','Forest','Canterbury','South East Asia','>No Information Currently Available','380000','0.931','38675','0','0','0.1','3537.8','365.46425','1292.939424','4.3287','7.3379','7.037','64','82','89');
INSERT INTO provinces  VALUES ('Australia_NewZealandFiordland','859,496','874,495','876,482',TRUE,'Te Anau','Forest','Fiordland','South East Asia','>No Information Currently Available','2900','0.931','38675','0','0','0.1','26.999','371.17125','10.02125258','0.2412','7.3651','0.4612','56','82','62');

INSERT INTO worlds VALUES('EPTR65E23EJ4HFTZ','Elysium','Earth','30',4);
INSERT INTO players (Country_Name,Hashed_Password,Country_Type,Colour,World_Code,Military_Influence,Military_Generation,Culture_Influence,Culture_Generation,Economic_Influence,Economic_Generation,Last_Event_Time,events_Stacked) VALUES('ADMIN','16a31e1e410ad60975f5f789dcb2ba3498a810ee1dd0b386057057fe2277af27', 'Tribe','ee82ee','EPTR65E23EJ4HFTZ',150,1,150,1,150,1,'2021-02-15 17:34:00',0);
INSERT INTO province_Occupation (World_Code,Province_ID,Country_Name,Province_Type,Building_Column_1,Building_Column_2) VALUES('EPTR65E23EJ4HFTZ','China_Beijing','ADMIN',"Culture","C4","M4");