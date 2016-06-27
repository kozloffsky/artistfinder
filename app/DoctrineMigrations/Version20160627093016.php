<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160627093016 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("UPDATE `category` SET title='Dancers - Dance Shows', description=\"When you want to add a touch of energy and emotion to your event whilst getting everybody's attention\" , slug='dance_shows', lft=1, rgt=20 WHERE id=31");
        $this->addSql('UPDATE `category` SET title=\'Dance group\' , slug=\'dance_group\', lft=14, rgt=15, lvl=1 WHERE 
        id=32');
        $this->addSql('UPDATE `category` SET title=\'Flash mobs\' , slug=\'flash_mobs\', lft=16, rgt=17, lvl=1 WHERE 
        id=33');
        $this->addSql('UPDATE `category` SET title=\'Ballroom dancers\' , slug=\'ballroom_dancers\', lft=18, rgt=19, 
        lvl=1 WHERE id=34');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (42, 31, 31, \'Salsa dancers\', \'salsa_dancers\', 2,3,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (43, 31, 
        31, \'Latin dancers\', \'latin_dancers\',4,5,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (44, 31, 31, 
        \'Belly dancers\', \'belly_dancers\', 6,7,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (45, 31, 31, 
        \'World & Cultural dancers\', \'cultural_dancers\',8,9,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (46, 31, 31, 
        \'Hip Hop / Breakdancers\', \'hip_hop\',10,11,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (47, 31, 31, 
        \'Cabaret dancers\', \'cabaret_dancers\',12,13,1)');



        $this->addSql('UPDATE `category` SET title=\'Children Entertainers\', description=\'When you need to give the
         little ones a memorable time, this is where you need to look\' , slug=\'children_entertainers\', lft=1, 
         rgt=24 WHERE id=35');
        $this->addSql('UPDATE `category` SET title=\'Magicians for children parties\' , 
        slug=\'magicians_for_children_parties\', lft=2, rgt=3, lvl=1 WHERE id=36');
        $this->addSql('UPDATE `category` SET title=\'Balloon twisters\' , slug=\'balloon_twisters\', lft=4, rgt=5, 
        lvl=1 WHERE id=37');
        $this->addSql('UPDATE `category` SET title=\'Costumed characters\' , slug=\'costumed_characters\', lft=6, 
        rgt=7, lvl=1 WHERE id=38');
        $this->addSql("UPDATE `category` SET title=\"Children's music / Kid Disco\" , slug='children', lft=8, rgt=9,
         lvl=1 WHERE id=39");
        $this->addSql('UPDATE `category` SET title=\'Clowns\' , slug=\'clowns\', lft=10, rgt=11, lvl=1 WHERE id=40');
        $this->addSql('UPDATE `category` SET title=\'Educational\' , slug=\'educational\', lft=12, rgt=13, lvl=1 
        WHERE id=41');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (48, 35, 35, 
        \'Face painters\', \'face_painters\',14, 15,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (49, 35, 35, 
        \'Themed parties\', \'themed_parties\', 16,17,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (50, 35, 35, 
        \'puppet shows\', \'puppet_shows\',18,19,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (51, 35, 35, 
        \'cartoonist\', \'cartoonist\',20,21,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (52, 35, 35, 
        \'Story teller\', \'story_teller\',22,23,1)');



        $this->addSql('UPDATE `category` SET title=\'Speakers, Hosts, Presenters\', description=\'From guest speakers to MCs, presenters and toast-masters, you need the right people to make your event run smoothly\' , slug=\'speakers_hosts_presenters\', lft=1, rgt=22 WHERE id=24');
        $this->addSql('UPDATE `category` SET title=\'Auctioneer\' , slug=\'auctioneer\', lft=2, rgt=3, 
        lvl=1 WHERE id=25');
        $this->addSql('UPDATE `category` SET title=\'Celebrity Speaker\' , slug=\'celebrity_speaker\', lft=4, rgt=5, 
        lvl=1 WHERE id=26');
        $this->addSql('UPDATE `category` SET title=\'EMCEE\' , slug=\'emcee\', lft=6, rgt=7, 
        lvl=1 WHERE id=27');
        $this->addSql('UPDATE `category` SET title=\'inspirational Speaker\' , slug=\'inspirational_speaker\', lft=8,
         rgt=9, 
        lvl=1 WHERE id=28');
        $this->addSql('UPDATE `category` SET title=\'Political Speaker\' , slug=\'political_speaker\', lft=10, rgt=11, 
        lvl=1 WHERE id=29');
        $this->addSql('UPDATE `category` SET title=\'Sports Speakers\' , slug=\'sports_speakers\', lft=12, rgt=13, 
        lvl=1 WHERE id=30');

        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (53, 24, 24, 
        \'Author\', \'author\',14,15,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (54, 24, 24, 
        \'Corporate Speaker\', \'corporate_speaker\',16,17,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (55, 24, 24, 
        \'Public Speaker\', \'public_speaker\',18,19,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (56, 24, 24, 
        \'Wedding officiant\', \'wedding_officiant\',20,21,1)');


        
        $this->addSql('UPDATE `category` SET title=\'Specialty Acts\' , slug=\'specialty_acts\', description=\'In the true "cabaret" 
tradition, these original acts will keep you amazed, laughing and sometimes on the edge of your seat\', lft=1, rgt=46 
WHERE 
        id=1');
        $this->addSql('UPDATE `category` SET title=\'Walkabout\' , slug=\'walkabout\', lft=2, rgt=3, lvl=1 WHERE id=2');
        $this->addSql('UPDATE `category` SET title=\'painters / Graffiti\' , slug=\'painters_graffiti\', lft=4, 
        rgt=5, lvl=1 WHERE id=3');
        $this->addSql('UPDATE `category` SET title=\'Magician / Illusionists\' , slug=\'magician_illusionists\', 
        lft=6, rgt=7, lvl=1 WHERE 
        id=4');
        $this->addSql('UPDATE `category` SET title=\'Hypnotist\' , slug=\'hypnotist\', lft=8, rgt=9, lvl=1 WHERE id=5');
        $this->addSql('UPDATE `category` SET title=\'Comedy Acts\', slug=\'comedy_acts\', lft=10, rgt=11, lvl=1 WHERE 
        id=6');
        $this->addSql('UPDATE `category` SET title=\'Stand-up Comedians\', slug=\'stand_up_comedians\', lft=12, rgt=13,
         lvl=1 WHERE id=7');
        $this->addSql('UPDATE `category` SET title=\'Parkoor / Stuntmen\', slug=\'parkoor_stuntmen_act\', lft=14, 
        rgt=15, lvl=1 WHERE id=8');
        $this->addSql('UPDATE `category` SET title=\'Impersonators\', slug=\'impersonators\', lft=16, rgt=17, lvl=1 
        WHERE id=9');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (57, 1, 1, 
        \'Sport show\', \'sport_show\',18,19,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (58, 1, 1, 
        \'Technology Acts\', \'technology_acts\',20,21,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (59, 1, 1, 
        \'LED Acts\', \'led_acts\',22,23,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (60, 1, 1, 
        \'Acrobats / Aerialists\', \'acrobats_aerialists\',24,25,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (61, 1, 1, 
        \'Contortionists\', \'contortionists\',26,27,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (62, 1, 1, 
        \'Jugglers\', \'jugglers\',28,29,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (63, 1, 1, 
        \'Burlesque\', \'burlesque\',30,31,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (64, 1, 1, 
        \'Fire Acts\', \'fire_acts\',32,33,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (65, 1, 1, 
        \'Stilt Walkers\', \'stilt_walkers\',34,35,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (66, 1, 1, 
        \'Circus Acts\', \'circus_acts\',36,37,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (67, 1, 1, 
        \'Clowns & Mimes\', \'clowns_mimes\',38,39,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (68, 1, 1, 
        \'Animal Acts\', \'animal_acts\',40,41,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (69, 1, 1, 
        \'Caricaturists\', \'caricaturists\',42,43,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (70, 1, 1, 
        \'World & Cultural\', \'world_cultural\',44,45,1)');


        $this->addSql('UPDATE `category` SET title=\'Live bands & Singers\', slug=\'live_bands_singers\', 
        description=\'All music styles covered, find the right talents to rock or jazz up your next event\', lft=1, 
        rgt=56 WHERE id=10');
        $this->addSql('UPDATE `category` SET title=\'Acoustic\', slug=\'acoustic\', lft=2, rgt=3, lvl=1  WHERE id=11');
        $this->addSql('UPDATE `category` SET title=\'Alternative\', slug=\'alternative\', lft=4, rgt=5, lvl=1  WHERE 
        id=12');
        $this->addSql('UPDATE `category` SET title=\'Rock\', slug=\'rock\', lft=6, rgt=7, lvl=1  WHERE id=13');
        $this->addSql('UPDATE `category` SET title=\'Pop\', slug=\'pop\', lft=8, rgt=9, lvl=1  WHERE id=14');
        $this->addSql('UPDATE `category` SET title=\'Cover & top 40\', slug=\'cover\', lft=10, rgt=11, lvl=1  WHERE 
        id=15');
        $this->addSql('UPDATE `category` SET title=\'Dance & Disco\', slug=\'dance_disco\', lft=12, rgt=13, lvl=1  
        WHERE id=16');
        $this->addSql('UPDATE `category` SET title=\'Party / Wedding\', slug=\'party_wedding\', lft=14, rgt=15, lvl=1 
         WHERE id=17');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (71, 10, 10, 
        \'Funk\', \'funk\',16,17,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (72, 10, 10, 
        \'Folk\', \'folk\',18,19,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (73, 10, 10, 
        \'Electro\', \'electro\',20,21,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (74, 10, 10, 
        \'Heavy Metal\', \'heavy_metal\',22,23,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (75, 10, 10, 
        \'Indie\', \'indie\',24,25,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (76, 10, 10, 
        \'Oldies\', \'oldies\',26,27,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (77, 10, 10, 
        \'70s-90s\', \'70s-90s\',28,29,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (78, 10, 10, 
        \'Jazz\', \'jazz\',30,31,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (79, 10, 10, 
        \'Swing\', \'swing\',32,33,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (80, 10, 10, 
        \'tribute\', \'tribute\',34,35,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (81, 10, 10, 
        \'soul\', \'soul\',36,37,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (82, 10, 10, 
        \'Latin\', \'latin\',38,39,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (83, 10, 10, 
        \'World & Cultural\', \'world_cultural_music\',40,41,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (84, 10, 10, 
        \'Orchestra\', \'orchestra\',42,43,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (85, 10, 10, 
        \'Marching band\', \'marching_band\',44,45,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (86, 10, 10, 
        \'Gospel\', \'gospel\',46,47,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (87, 10, 10, 
        \'Reggae\', \'reggae_sing\',48,49,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (88, 10, 10, 
        \'Irish\', \'irish\',50,51,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (89, 10, 10, 
        \'Scottish\', \'scottish\',52,53,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (90, 10, 10, 
        \'Choir\', \'choir\',54,55,1)');

        $this->addSql('UPDATE `category` SET title=\'Musicians & DJs\', slug=\'musicians_djs\', description=\'Need a solo musician or DJ? Every style is available to create the right ambience\', lft=1, rgt=60 WHERE id=18');
        $this->addSql('UPDATE `category` SET title=\'Classical duos\', slug=\'classical_duos\', lft=2, rgt=3, lvl=1  WHERE 
        id=19');
        $this->addSql('UPDATE `category` SET title=\'string trios / quartets\', slug=\'string_trios_quartets\', 
        lft=4, rgt=5, lvl=1  WHERE 
        id=20');
        $this->addSql('UPDATE `category` SET title=\'Pianists\', slug=\'pianists\', lft=6, rgt=7, lvl=1  WHERE id=21');
        $this->addSql('UPDATE `category` SET title=\'Guitarists\', slug=\'guitarists\', lft=8, rgt=9, lvl=1  WHERE 
        id=22');
        $this->addSql('UPDATE `category` SET title=\'Bassists\', slug=\'bassists\', lft=10, rgt=11, lvl=1  WHERE 
        id=23');

        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (91, 18, 18, 
        \'Violinist & Cellist\', \'violinist_cellist\',12,13,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (92, 18, 18, 
        \'Saxophonists\', \'saxophonists\',14,15,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (93, 18, 18, 
        \'World /Cultural\', \'world_cultural_dj\',16,17,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (94, 18, 18, 
        \'Harpists\', \'harpists\',18,19,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (95, 18, 18, 
        \'Trumpeters\', \'trumpeters\',20,21,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (96, 18, 18, 
        \'Drummers\', \'drummers\',22,23,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (97, 18, 18, 
        \'Percussionists\', \'percussionists\',24,25,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (98, 18, 18, 
        \'Accordion\', \'accordion\',26,27,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (99, 18, 18, 
        \'One man band\', \'one_man_band\',28,29,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (100, 18, 18, 
        \'Flutists\', \'flutists\',30,31,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (101, 18, 18, 
        \'Bagpipers\', \'bagpipers\',32,33,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (102, 18, 18, 
        \'Electro DJs\', \'electro_djs\',34,35,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (103, 18, 18, 
        \'House DJs\', \'house_djs\',36,37,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (104, 18, 18, 
        \'Electro House\', \'electro_house\',38,39,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (105, 18, 18, 
        \'Progressive\', \'progressive\',40,41,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (106, 18, 18, 
        \'Techno DJs\', \'techno_djs\',42,43,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (107, 18, 18, 
        \'Trance DJs\', \'trance_djs\',44,45,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (108, 18, 18, 
        \'Funk / R&B DJs\', \'funk-r&b_djs\',46,47,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (109, 18, 18, 
        \'Hip Hop DJs\', \'hip_hop_djs\',48,49,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (110, 18, 18, 
        \'Chill out DJs\', \'chill_out_djs\',50,51,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (111, 18, 18, 
        \'Dubstep DJs\', \'dubstep_djs\',52,53,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (112, 18, 18, 
        \'Dance DJs\', \'dance_djs\',54,55,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (113, 18, 18, 
        \'Drum & Bass DJs\', \'drum_bass_djs\',56,57,1)');
        $this->addSql('INSERT INTO `category` (`id`, `root_id`, `parent_id`, `title`, `slug`, `lft`, `rgt`, `lvl`) VALUES (114, 18, 18, 
        \'Reggae\', \'reggae\',58,59,1)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
