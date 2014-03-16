<?php
class PLUGIN extends API{
	private $plugin;
	/**
     * 
     * Create the plugin
     *
     * @param string $plugin_name  Name of the plugin
     * @param string $plugin_name  Author's full name
     * @param string $plugin_name  Version of the plugin
     * @return boolean
     */
	public function __construct($plugin_name, $plugin_author, $plugin_version){
		global $mysql_server, $mysql_user, $mysql_pass, $mysql_db;
		$this->connect($mysql_server, $mysql_user, $mysql_pass, $mysql_db);
		$plugin_name = $this->sql_escape($plugin_name);
		$plugin_author = $this->sql_escape($plugin_author);
		$plugin_version = $this->sql_escape($plugin_version);
		$this->plugin[name] = $plugin_name;
		$this->plugin[author] = $plugin_author;
		$this->plugin[version] = $plugin_version;
		
		if(!$this->get_plugin($plugin_name)){
			if(!$this->query("INSERT into PLUGINS(id,name,author,version) VALUES('','$plugin_name', '$plugin_author', '$plugin_version')"))
				throw new Exception("Error: Plugin could not be added to database.");
		}
		else {
			if(!$this->query("UPDATE PLUGINS SET version='$plugin_version' WHERE name='$plugin_name'"))
				throw new Exception("Error: Plugin could not be updated from database.");
			if(!$this->query("UPDATE PLUGINS SET author='$plugin_author' WHERE name='$plugin_name'"))
				throw new Exception("Error: Plugin could not be updated from database.");
		}
		return true;
 	}
	
	/**
     * 
     * Adds a new mode
	 * 
     *
     * @param string $name Name of the Mode or, better called Submode
     * @param string $route The route is where the mode will be plugged. It can be user, staff or admin
     * @param string $file Name of the file that contains the mode.
     * @return boolean
     */
	public function add_mode($name, $route, $file){
		$name = $this->sql_escape($name);
		$route = $this->sql_escape($route);
		$file = $this->sql_escape($file);
		$plugin_name = $this->plugin[name];
		if(!$this->query("INSERT into MODES(id,plugin,name,route,file) VALUES('','$plugin_name', '$name', '$route','$file')"))
			throw new Exception("Error: Mode could not be added.");
		return true;
	}
	
	/**
     * 
     * Delete mode
	 * 
     *
     * @param string $name Name of the Mode or, better called Submode
     * @param string $route The route is where the mode will be plugged. It can be user, staff or admin
     * @param string $file Name of the file that contains the mode.
     * @return boolean
     */
	public function delete_mode($name){
		$name = $this->sql_escape($name);
		$plugin_name = $this->plugin[name];
		if(!$this->query("DELETE FROM MODES WHERE plugin='$plugin_name' AND name='$name'"))
			throw new Exception("Error: Mode could not be deleted.");
		return true;
	}

	/**
     * 
     * Adds code to a file
	 * 
     *
     * @param string $route The route is where the code will be added.
     * @param string $file Name of the file that contains the code to add.
	 * @param boolean $atstart Will the code be put at start?
     * @return boolean
     */
	public function add_code($route, $file, $atstart){
		$route = $this->sql_escape($route);
		$file = $this->sql_escape($file);
		$atstart = ($atstart) ? 1 : 0;
		$plugin_name = $this->plugin[name];
		if(!$this->query("INSERT into CODE(id,plugin,file,route,atstart) VALUES('','$plugin_name','$file','$route','$atstart')"))
			throw new Exception("Error: Code could not be added.");
		return true;
	}
	
	/**
     * 
     * Delete a code query
	 * 
     *
     * @param string $route The route is where the code added.
     * @param string $file Name of the file that contains the code.
	 * @param boolean $atstart Is the code at start?
     * @return boolean
     */
	public function delete_code($route, $file){
		$route = $this->sql_escape($route);
		$file = $this->sql_escape($file);
		$plugin_name = $this->plugin[name];
		if(!$this->query("DELETE FROM CODE WHERE plugin='$plugin_name' AND route='$route' AND file='$file'"))
			throw new Exception("Error: Code could not be deleted.");
		return true;
	}
	
	/**
     * 
     * Adds a new Extra
     *
	 * @param string $name Name of the Extra
	 * @param string $value Value of the Extra
	 * @param string $type Type of the Extra
	 * @param int $toid An ID to link with the extra if it has.
 	 * @return boolean returns true.
     */
	public function add_extra($name, $value, $type, $toid){
		return parent::add_extra($name, $value, $type, $toid, $this->plugin[name]);
	}
	/**
     * 
     * Creates a new property
     *
	 * @param string $name Name of the property
	 * @param boolean $iseditable True if the user/staff can edit the property
	 * @param string $type It can be user/staff/tickets.
	 * @param string $input It can be select/checkbox/text
	 * @param string|array $value If property is checkbox (1 or 0) or text, set the default value here. If it is select, set an array with options. Ex: $value[0] = 'first option'; $value[1] = 'second option';
 	 * @param boolean $filter Is the property a filter for staff?
	 * @return boolean Returns true.
     */
	public function new_property($name, $iseditable, $type, $input, $value, $filter){
		return parent::new_property($name, $iseditable, $type, $input, $value, $this->plugin[name]);
	}
	
	/**
     * 
     * Add a new row to TEXT table
	 * You can create the same text to be used in varius languages
	 * add_text("Hello World", "Hello World", "text", "en", "myplugin");
	 * add_text("Hello World", "Hola mundo", "text", "es", "myplugin");
	 * add_text("Hello World", "Hallo Welt", "text", "en", "myplugin");
     *
	 * @param string $title Title of the text
	 * @param string $content Content of the text
	 * @param string $type Type of the text. Use $type='text' if you want it to appear in $TEXT variable.
	 * @param string $lang Language of the text
	 * @return array Retruns array with all text info.
     */
	public function add_text($title, $content, $type, $lang){
		return parent ::add_text($title, $content, $type, $lang, $this->plugin[name]);
	}
}
?>