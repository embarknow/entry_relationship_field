<?php
	/*
	Copyight: Deux Huit Huit 2014
	LICENCE: MIT http://deuxhuithuit.mit-license.org;
	*/
	
	if(!defined("__IN_SYMPHONY__")) die("<h2>Error</h2><p>You cannot directly access this file</p>");
	
	require_once(EXTENSIONS . '/entry_relationship_field/fields/field.entry_relationship.php');
	
	/**
	 *
	 * @author Deux Huit Huit
	 * http://www.deuxhuithuit.com
	 *
	 */
	class extension_entry_relationship_field extends Extension {

		/**
		 * Name of the extension
		 * @var string
		 */
		const EXT_NAME = 'Entry Relationship Field';
		
		/**
		 * Symphony utility function that permits to
		 * implement the Observer/Observable pattern.
		 * We register here delegate that will be fired by Symphony
		 */

		public function getSubscribedDelegates(){
			return array(
				array(
					'page' => '/backend/',
					'delegate' => 'InitaliseAdminPageHead',
					'callback' => 'appendAssets'
				)
			);
		}

		/**
		 *
		 * Appends javascript file references into the head, if needed
		 * @param array $context
		 */
		public function appendAssets(array $context) {
			// store the callback array locally
			$c = Administration::instance()->getPageCallback();
			
			// publish page
			if($c['driver'] == 'publish') {
				Administration::instance()->Page->addStylesheetToHead(
					URL . '/extensions/entry_relationship_field/assets/publish.entry_relationship_field.css',
					'screen',
					time() + 1,
					false
				);
				Administration::instance()->Page->addScriptToHead(
					URL . '/extensions/entry_relationship_field/assets/publish.entry_relationship_field.js',
					time(),
					false
				);
				
			} else if ($c['driver'] == 'blueprintssections') {
				Administration::instance()->Page->addStylesheetToHead(
					URL . '/extensions/entry_relationship_field/assets/section.entry_relationship_field.css',
					'screen',
					time() + 1,
					false
				);
				Administration::instance()->Page->addScriptToHead(
					URL . '/extensions/entry_relationship_field/assets/section.entry_relationship_field.js',
					time(),
					false
				);
			}
		}

		/* ********* INSTALL/UPDATE/UNINSTALL ******* */

		/**
		 * Creates the table needed for the settings of the field
		 */
		public function install() {
			General::realiseDirectory(WORKSPACE . '/er-templates');
			return FieldEntry_relationship::createFieldTable();
		}

		/**
		 * Creates the table needed for the settings of the field
		 */
		public function update($previousVersion) {
			return true;
		}

		/**
		 *
		 * Drops the table needed for the settings of the field
		 */
		public function uninstall() {
			return FieldEntry_relationship::deleteFieldTable();
		}

	}