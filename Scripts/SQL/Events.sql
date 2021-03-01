INSERT INTO Events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Dissidents In Our Government',
'Recent investigations have confirmed the existence of high ranking officials opposed to official government policy, having such persons in our administration threatens to undermine our authority, what actions should we take with these dissidents?',
50,1,2,3);

INSERT INTO Options VALUES(1,'These rebels should be removed from their offices at once',-0.04,0,0.04);
INSERT INTO Options VALUES(2,'Our government must be open to all opinions',0.03,0.02,-0.06);
INSERT INTO Options VALUES(3,'Perhaps we can pretend they simply do not exist',-0.01,-0.01,-0.01);

INSERT INTO Events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Riches Untold',
'Spurred on by a popular tabloid, rumours have begun to circulate that under a recently constructed town lies a large amount of gold. Our Advisors assure us that there is no such thing, but yet the public still calls for us to demolish and excavate the site.',
30,4,5,6);

INSERT INTO Options VALUES(4,'Release evidence disproving the baseless rumours',-0.05,0,0.02);
INSERT INTO Options VALUES(5,'It is just a harmless rumor, perhaps we can just let the people imagine?',0.04,0,-0.01);
INSERT INTO Options VALUES(6,'Excavate the site to disprove the rumor once and for all',-0.03,-0.04,0.03);

INSERT INTO Events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Counter Culture',
'Recently, an obscure village on the fringes of our country have began to develop traditions of their own, many of which contradict our peoples own beliefs. Public outcry has called for us to suppress these so called harmful revolutionaries.',
40,7,8,9);

INSERT INTO Options VALUES(7,'Send a police task force to deal with them',0.02,0,0.03);
INSERT INTO Options VALUES(8,'Threaten to cut vital subsidies to the region',0.01,-0.02,0.01);
INSERT INTO Options VALUES(9,'Allow them to practice what they wish',-0.03,0.02,0);

INSERT INTO Events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Creature Comforts',
'Zoologists under our funding have discovered a new species of freshwater fish native to rivers in our nation. Since the discovery of these fish, their population has skyrocketed, harming local ecosystems. Local communities have asked us to intervene to protect their interests in the area.',
25,10,11,12);

INSERT INTO Options VALUES(10,'Nonsense! These unique and beautiful animals will be our new national animal!',0.04,-0.04,0);
INSERT INTO Options VALUES(11,'Cull the population to acceptable levels',-0.01,0.03,0);
INSERT INTO Options VALUES(12,'This is really not an issue of national importance, they can deal with it how they see fit.',0,0.01,0);

INSERT INTO Events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Placebo Particle',
'After the installation of a nuclear power plant near a rural town locals have began to complain of frequent headaches and pains, and in some cases even vomiting. Investigation into the matter has cleared any suspicion of radiation-related causes, yet the locals have organised a blockade of the facility in protest, the power company has turned to us for help in this crisis.',
45,13,14,15);

INSERT INTO Options VALUES(13,'Blockading the nuclear plant is putting them in more danger than any fake symptoms, they must be dispersed by force.',0,0.02,0.03);
INSERT INTO Options VALUES(14,'Agree to demolish the plant to appease the people',0.02,-0.05,-0.02);
INSERT INTO Options VALUES(15,'There cannot be *nothing* causing their illness, fund an investigation into the true causes of the symptoms',0.01,-0.01,-0.01);

INSERT INTO Events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Teach The Controversy',
'A small group of protesters have gathered to demand public education include modules on their frighteningly misguided conspiracy theories, calling the lack of such topics censorship',
30,16,17,18);

INSERT INTO Options VALUES(16,'We cannot allow our children to believe such nonsense',-0.01,0.03,0);
INSERT INTO Options VALUES(17,'Of course! Teaching all sides of a debate teaches children critical thinking skills.',0.02,-0.05,0);
INSERT INTO Options VALUES(18,'School should only be for teaching productive skills. We should remove all irrelevant subjects from the curriculum',-0.06,0.06,0.02);

INSERT INTO Events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Quality Of Strife',
'An obscure murder trial has sparked national controversy after the defence team declared it a consentual duel between adults, resulting in a not guilty verdict. All participants in the trial have been disbarred for their actions which clearly violate state law, but some protesters claim the verdict should be maintained, and furthermore, dueling should be legalised between consenting partners.',
40,19,20,21);

INSERT INTO Options VALUES(19,'Duels are an archaic system that cannot be permitted within a modern nation.',-0.03,0.03,-0.03);
INSERT INTO Options VALUES(20,'Such a rich part of our history cannot be ignored. Duels should be legal once more.',0.05,-0.05,0.02);
INSERT INTO Options VALUES(21,'Duels should only be permitted to those who hold military positions, perhaps they can serve as an alternate method of training?',0,-0.01,0.03);

INSERT INTO Events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Territorial Extent',
'A foreign group of settlers have erected a new village near our national borders. This would not normally be an issue, but the villagers are claiming that some fertile land within our borders should belong to them, due to its lack of development and closeness to the town. Media pressure has forced us to confront this issue and release a response to the incident.',
40,22,23,24);

INSERT INTO Options VALUES(22,'Our land is *our* land.',0.02,0,0.03);
INSERT INTO Options VALUES(23,'The land in question is not in use, perhaps we can loan some territory to the villagers. For a price, of course.',-0.02,0.04,-0.01);
INSERT INTO Options VALUES(24,'Surrender the land in the name of peace, we had no need for it anyway.',0.02,0,-0.04);

INSERT INTO Events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Technophilia',
'One of our top national universities has unveiled a startling invention - a prosthetic limb capable of perfect one to one motion, with joints perfectly capable of recreating human level movement. The team behind this revolutionary technology primarily consists of foreign scholarship students, who have requested the exclusive production rights be granted to their home country.',
50,25,26,27);

INSERT INTO Options VALUES(25,'Grant them their wish. They created the technology, and so should have say on how it is used.',0.05,-0.03,0);
INSERT INTO Options VALUES(26,'The device could not even have been invented without our help, it should be free to all nations.',0.01,0.03,-0.01);
INSERT INTO Options VALUES(27,'This is an invention of our country, and the production rights belong to our country alone.',-0.03,0.04,0.04);

INSERT INTO Events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('A New Form Of Warfare',
'Following a recent cyberattack on a foreign nation, which temporarily disabled energy distribution to an entire city, our military advisors have suggested we form of branch of military dedicated to defense against cyberattacks, lest a similar situation happen to us. The iniative would certainly be expensive however, as it requires funding an entirely new war department.',
60,28,29,30);

INSERT INTO Options VALUES(28,'Who says it has to be purely defensive? This technology could give us the upper hand in global conflicts...',-0.02,-0.03,0.06);
INSERT INTO Options VALUES(29,'Modernising the nation is certainly important, but the costs outweigh the benefits.',0,0.03,-0.03);
INSERT INTO Options VALUES(30,'Funding this project is essential to maintaining the safety of our nation.',0.01,-0.04,0.04);

INSERT INTO Events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Black Gold',
'An illegal drilling operation in a wildlife conservation zone has discovered a large supply of oil under said national park. While the perpetrators originally tried to hide their discovery, locals quickly spread the news and the drilling team has been arrested. The question remains, what do we do with all this newfound oil?',
50,31,32,33);

INSERT INTO Options VALUES(31,'Bury it. We cannot harm this beautiful landscape more than we already have',0.06,-0.03,-0.02);
INSERT INTO Options VALUES(32,'Authorise the extraction and sale of small quantities at a time, while being careful not to damage the local ecosystem.',-0.01,0.04,0);
INSERT INTO Options VALUES(33,'We always have more national parks. Tear the place up and hire a professional drilling company to extract all we can.',-0.05,0.03,0.02);

INSERT INTO Events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Return To Sender',
'Our military decryption specialists have uncovered a communication between a foreign power and their ally. The message requests for aid in an immenent attack on their mutual enemy. Said enemy is an important economic partner of ours, and we could benefit greatly from releasing this information, but it certainly would not make us any friends.',
50,34,35,36);

INSERT INTO Options VALUES(34,'Release the document. I am sure our friends will be quite appriciative.',-0.03,0.03,0.05);
INSERT INTO Options VALUES(35,'Pretend we never saw the letter. It is not worth getting involved in foreign squabbles.',0.03,0,-0.02);
INSERT INTO Options VALUES(36,'We could all stand to make a lot of money were we to ransom this document to its sender.',-0.05,0.07,0.03);

INSERT INTO Events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Private Correspondence',
'An international company has offered some interesting rewards, were we to wait until a certain date to enact a regulation currently under review. This would provide significant new funding for our government, but would be blatant corporate favouritism were it to be discovered.',
35,37,38,39);

INSERT INTO Options VALUES(37,'The extra revenue from this deal could be used to directly benefit the people. Does it really matter where the money came from?',-0.06,0.06,0);
INSERT INTO Options VALUES(38,'We are willing to negotiate, but if this conversation leaks, there will be consequences.',-0.03,0.04,0.03);
INSERT INTO Options VALUES(39,'This is blatant corruption',0.04,-0.04,-0.01);

INSERT INTO Events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Watergate Scandal',
'During the night, a local reservoir was destroyed as an unknown group released the floodgates during the night. Though thankfully not impacting any residents, the resulting flood significantly damaged the local wildlife. The actors in this scheme are not yet known, but evidence points that the damage was done intentionally',
20,40,41,42);

INSERT INTO Options VALUES(40,'A full investigation should be done, and the instigators should face consequences',0.01,0,0.03);
INSERT INTO Options VALUES(41,'Most likely this was an act of drunks or teenagers. Chasing up the criminals will do nothing to help, we should focus on recovery',0.04,0.01,-0.03);
INSERT INTO Options VALUES(42,'This newly free land would be the perfect place for a new housing estate',-0.04,0.06,0);

INSERT INTO Events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('National Ridicule',
'Last night, a satirical advertisement was ran on television networks nationwide. The advertisement did not seem to attempt to sell or promote any product, and simply criticised government policy for minutes on end before abruptly ending. What actions shall we take in response to this?',
40,43,44,45);

INSERT INTO Options VALUES(43,'If the people behind this attack want to spend money on criticising our nation, they can do so as they please.',0.04,-0.02,-0.02);
INSERT INTO Options VALUES(44,'Ban the commercial from airing. This is an innapropriate use of technology.',-0.06,0.02,0.04);
INSERT INTO Options VALUES(45,'Acknowledge the advertisement publicly and laugh off the criticisms.',0.05,-0.02,-0.04);

INSERT INTO Events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Diplomancy',
'Recently, an embassy stationed in our capital has gained significant backlash for an comment made by an official stating that ethnic groups within our nation should be subject to the laws of their homeland. This offhand statement has incited national debate, and while the official who originally made the statement has backed down from this stance, we are still expected to release an announcement regarding the controversy',
45,46,47,48);

INSERT INTO Options VALUES(46,'This is akin to giving up national sovereignty',-0.03,0.04,0.02);
INSERT INTO Options VALUES(47,'Expel the embassy for these utterly inappropriate comments',-0.06,0,0.06);
INSERT INTO Options VALUES(48,'Ethnic groups should be able to decide their own rights and responsibilities, with oversight from our government of course',0.05,0,-0.05);

INSERT INTO Events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Forced Philanthropy',
'It has come to the attention of our government that, while homelessness has never been higher within our nation, there are many unoccupied houses belonging to various landlords and companies. Were we to release even a fraction of these houses, homelessness in our country would drop significantly.',
45,49,50,51);

INSERT INTO Options VALUES(49,'Seize the homes and release them at a discounted price to homeless persons',0.03,-0.04,0.04);
INSERT INTO Options VALUES(50,'Enact a law restricting the maximum amount of homes a person or company can own',0.06,-0.03,0.01);
INSERT INTO Options VALUES(51,'These properties were aquired lawfully, we cannot simply take them from their owners',-0.03,0.05,0);

INSERT INTO Events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Sheepish',
'This morning our department incharge of agricultural affairs recieved a worrying email. The email came from the head of a local farming conglomerate who admitted he had personally gambled away the farming subsidies provided to his business, and with a looming rise in demand for agricultural goods, he has come to humbly request we grant him more subsidies.',
30,52,53,54);

INSERT INTO Options VALUES(52,'Now more than ever, our citizens need to eat healthily. If we do not provide subsidies we are punishing our people more than we are punishing the company',0.03,0.03,-0.04);
INSERT INTO Options VALUES(53,'Arrest the head and grant subsidies to his replacement',0,0.03,0.06);
INSERT INTO Options VALUES(54,'Our citizens need food, and that is the exact reason why we should aquire the company as a government run business',-0.04,0.02,0.03);

INSERT INTO Events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('Tough Love',
'A high ranking naval commander was recently revealed to be having an affair with a member of his crew. The rest of his crew claim that this had no bearing on his performance as a commander, but there is still cause for concern, any distractions during wartime could be fatal.',
30,55,56,57);

INSERT INTO Options VALUES(55,'We cannot allow romance in military action',-0.06,0,0.05);
INSERT INTO Options VALUES(56,'We should only permit married individuals into military office, we could have our own modern Sacred Band of Thebes',0.03,0,0.03);
INSERT INTO Options VALUES(57,'Does it truly matter? Trained professionals are unlikely to be distracted when their lives are on the line',0.05,0,-0.06);

INSERT INTO Events (Title,Description,Base_Influence_Reward,Option_1_ID,Option_2_ID,Option_3_ID) VALUES ('The Games',
'An international sporting event has decided that our capital will be the host of their next competition. Should we accept the invitation, it would be our financial responsibility to provide necessary stadium, services and equipment. This would likely be incredibly expensive, and all ready we have protesters demanding we deny the invitation',
50,58,59,60);

INSERT INTO Options VALUES(58,'These events are a time for national celebration, it will be worth it no matter the cost.',0.08,-0.08,0);
INSERT INTO Options VALUES(59,'If we increase ticket prices and tax the local area higher than usual, we might be able to make our money back and then some',0.03,0.01,0.03);
INSERT INTO Options VALUES(60,'We cannot host the event, the financial burden would be too great',-0.05,0.05,0);