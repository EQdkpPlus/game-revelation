<?php
/*	Project:	EQdkp-Plus
 *	Package:	div game package
 *	Link:		http://eqdkp-plus.eu
 *
 *	Copyright (C) 2006-2016 EQdkp-Plus Developer Team
 *
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU Affero General Public License as published
 *	by the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU Affero General Public License for more details.
 *
 *	You should have received a copy of the GNU Affero General Public License
 *	along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}

if(!class_exists('revelation')) {
	class revelation extends game_generic {
		protected static $apiLevel	= 20;
		public $version				= '0.2.1';
		public $author				= "WalleniuM, Inkraja";
		protected $this_game		= 'revelation';
		protected $types			= array('races','classes','roles');
		protected $classes			= array();

		protected $roles			= array();
		protected $factions			= array();
		protected $filters			= array();
		protected $realmlist		= array();
		protected $professions		= array();
		public $langs				= array('german', 'english');

		protected $class_dependencies = array(
			array(
				'name'			=> 'race',
				'type'			=> 'races',
				'admin' 		=> false,
				'decorate'		=> false,
				'parent'		=> false,
			),
			array(
				'name'			=> 'class',
				'type'			=> 'classes',
				'admin'			=> false,
				'decorate'		=> true,
				'primary'		=> true,
				'colorize'		=> true,
				'roster'		=> true,
				'recruitment'	=> true,
				'parent'		=> array(
					'race' => array(
						1 	=> 'all',							// Human
					),
				),
			),

		);

		public $default_roles = array(
			1	=> array(2,6),				// healer
			2	=> array(3,4,5),			// tank
			3	=> array(1,3,4,5,6),		// dd
		);

		protected $class_colors		= array(
                        1       => '#336699', //Swordmage
                        2       => '#336633', //Spritishaper
                        3       => '#999900', //Vanguard
                        4       => '#993300', //Blademaster
                        5       => '#993333', //Gunslinger
                        6       => '#663399', //Occultist
		);

		protected $glang			= array();
		protected $lang_file		= array();
		protected $path				= '';
		public $lang				= false;

		public function __construct() {
			parent::__construct();
		}

		public function load_filters($langs){
			return array();
		}
		
		public function profilefields(){
			$fields = array(
				'guild'	=> array(
					'type'			=> 'text',
					'category'		=> 'character',
					'lang'			=> 'uc_guild',
					'size'			=> 32,
					'undeletable'	=> true,
					'sort'			=> 1
				),
				'gender'	=> array(
					'type'			=> 'dropdown',
					'category'		=> 'character',
					'lang'			=> 'uc_gender',
					'options'		=> array('male' => 'uc_male', 'female' => 'uc_female'),
					'tolang'		=> true,
					'undeletable'	=> true,
					'sort'			=> 3
				),
				'level'	=> array(
					'type'			=> 'spinner',
					'category'		=> 'character',
					'lang'			=> 'uc_level',
					'max'			=> 100,
					'min'			=> 1,
					'undeletable'	=> true,
					'sort'			=> 4
				),
			
			);
			return $fields;
		}
		
		public function install($install=false){
			$this->game->resetEvents();
			$arrEventIDs = array();
			$arrEventIDs[1] = $this->game->addEvent($this->glang('darkfall'), 0, "01.png");
			$arrEventIDs[2] = $this->game->addEvent($this->glang('deserted_shrine'), 0, "02.png");
			$arrEventIDs[3] = $this->game->addEvent($this->glang('misty_hallow'), 0, "03.png");
			$arrEventIDs[4] = $this->game->addEvent($this->glang('grand_bulwark'), 0, "04.png");
			$arrEventIDs[5] = $this->game->addEvent($this->glang('scour_dungeon'), 0, "05.png");
			$arrEventIDs[6] = $this->game->addEvent($this->glang('mech_citadel'), 0, "06.png");
			$arrEventIDs[7] = $this->game->addEvent($this->glang('bounty_hunter'), 0, "07.png");
			$arrEventIDs[8] = $this->game->addEvent($this->glang('clanwar'), 0, "08.png");
			
			$arrItemPools = array();
			$arrItemPools[0] = $this->game->addItempool('Raids', 'Raids Itempool');
			$arrItemPools[1] = $this->game->addItempool('ClanWar', 'ClanWar Itempool');

			$this->game->addMultiDKPPool('Raids', 'Raids', [1,2,3,4,5,6,7], [$arrItemPools[0]]);
			$this->game->addMultiDKPPool('CW', 'ClanwWar', [8], [$arrItemPools[1]]);


			//Links
			$this->game->addLink('RO Forum', 'https://ro.my.com/forum/board-list/');

			$this->game->resetRanks();
			//Ranks
			$this->game->addRank(0, "Guild Leader");
			$this->game->addRank(1, "Vice Guild");
			$this->game->addRank(2, "Chairperson");
			$this->game->addRank(3, "Grayscale Ennvoy");
			$this->game->addRank(4, "Scarletwing Envoy");
			$this->game->addRank(5, "Frostfang Envoy");
			$this->game->addRank(6, "Midnight Envoy");
			$this->game->addRank(7, "Elite");
			$this->game->addRank(8, "Member", true);
			$this->game->addRank(9, "Toon" );
			$this->game->addRank(10, "Alliance");
			
			//Raidgroups
			$this->game->addRaidgroup("Group1","#f44336", "", 0, 0, 0);
			$this->game->addRaidgroup("Group2","#e91e63", "", 0, 1, 0);
			$this->game->addRaidgroup("Group3","#9c27b0", "", 0, 2, 0);
			$this->game->addRaidgroup("Group4","#673ab7", "", 0, 3, 0);
			$this->game->addRaidgroup("Group5","#3f51b5", "", 0, 4, 0);
			$this->game->addRaidgroup("Group6","#2196f3", "", 0, 5, 0);
			$this->game->addRaidgroup("Group7","#03a9f4", "", 0, 6, 0);
			$this->game->addRaidgroup("Group8","#00bcd4", "", 0, 7, 0);
			$this->game->addRaidgroup("Group9","#009688", "", 0, 8, 0);
			$this->game->addRaidgroup("Group10","#4caf50", "", 0, 9, 0);
		}
		public function uninstall(){

			$this->game->removeLink("RO Forum");  

		}
		
		public function admin_settings() {
			// array with admin fields
			return array();
		}

	}#class
}
?>
