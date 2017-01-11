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
		public $author				= "WalleniuM";
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
			1	=> '#58D3F7',
			2	=> 'green',
			3	=> 'yellow',
			4	=> 'orange',
			5	=> 'red',
			6	=> 'gray',
		);

		protected $glang			= array();
		protected $lang_file		= array();
		protected $path				= '';
		public $lang				= false;

		public function __construct() {
			parent::__construct();
		}

		public function install($install=false){
			//config-values
			$info['config'] = array();
			return $info;
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

		public function admin_settings() {
			// array with admin fields
			return array();
		}

	}#class
}
?>
