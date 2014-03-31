<?php
 /**
  * @license http://opensource.org/licenses/gpl-license.php GNU Public License
  * @author Ivan Diaz <ivan@opensupports.com>
  */
class API{
	protected $conexion;
	protected $DATA = array();
	
	/**
     * 
     * Connects to database
     *
     * @param string $mysql_server  MySQL hostname
     * @param string $mysql_user  MySQL Login user
     * @param string $mysql_pass  MySQL Login password
     * @param string $mysql_db  MySQL Database of OpenSupports
     * @return boolean
     */
	public function connect($mysql_server, $mysql_user, $mysql_pass, $mysql_db){
		$this->conexion = mysqli_connect($mysql_server,$mysql_user,$mysql_pass);
		if(!$this->conexion) throw new Exception("Error 11: Can't connect to MySQL server");
		if(!mysqli_select_db($this->conexion, $mysql_db)) throw new Exception("Error 12: Can't connect to MySQL database");
		return true;
	}
	
	/**
     * 
     * Get data from database
     *
     * @return array All data info.
     */
	public function get_data(){
		if($query = $this->query("SELECT * FROM INFO"));
		while($reg = @mysqli_fetch_array($query)){
			$this->DATA["$reg[name]"] = $reg[value];
		}
		return $this->DATA;
	}
	
	/**
     * 
     * Create a new department
     *
     * @param string $name  Name of the new department
     * @return mixed Mysqli result
     */
	public function add_department($name){
		$name = $this->sql_escape($name);
		return $this->query("INSERT into DEPARTMENTS(id,name) VALUES('','$name')");
	}
	
	/**
     * 
     * Delete a department
     *
     * @param string $name  Name of the new department
     * @return mixed Mysqli result
     */
	public function delete_department($name){
		$name = $this->sql_escape($name);
		return $this->query("DELETE FROM DEPARTMENTS WHERE name='$name'");
	}
	
	/**
     * 
     * Erase all table content
     *
     * @param string $table  Table to drop. It can be 'users' or 'tickets'.
     * @return boolean Returns true when finished.
     */
	public function drop_table($table){
		if($table == "users"){
			$this->query("DELETE FROM USERS");
			$this->query("DELETE FROM EXTRA WHERE type='property'");
			return true;
		}
		elseif($table == "tickets"){
			$this->query("DELETE FROM TICKETS");
			$this->query("DELETE FROM COMMENTS");
			$this->query("DELETE FROM EXTRA WHERE type='propertyticket'");
			return true;
		}
		else{
			throw new Exception("Invalid table name");
		}
	}
	
	/**
     * 
     * Change a value of data table
     *
     * @param string $name  Name of the field to modify
	 * @param string $value New value for the field
     * @return boolean true
     */
	public function update_data($name, $value){
		$name = $this->sql_escape($name);
		$value = $this->sql_escape($value);
		if(!$this->query("UPDATE INFO SET value='$value' WHERE name='$name'")) throw new Exception("Couldn't find name");
		$this->DATA[$name] = $value;
		return true;
	}
	
	/**
     * 
     * Get all text stored in database
     *
     * @param string $lang  Lang of the text
     * @return array Array which contains the text in database. array['nameofthetext'] = text
     */
	public function get_text($lang){
		$lang = $this->sql_escape($lang);
		$query = $this->query("SELECT * FROM TEXT WHERE lang='$lang' AND type='text'");
		$txt = array();
		while($reg = @mysqli_fetch_array($query)){
			$txt["$reg[name]"] = $reg[value];
		}
		return $txt;
	}
	
	/**
     * 
     * Returns query with a list of all departments
     *
     * @return mixed Query with all departments
     */
	public function get_departments(){
		return $this->query("SELECT * FROM DEPARTMENTS ORDER BY name ASC");
	}
	
	/**
     * 
     * Returns query with a list of all documents and guides
     *
     * @return mixed Query with all documents and guides
     */
	public function get_docs(){
		return $this->query("SELECT * FROM DOCS ORDER BY id DESC");
	}
	
	/**
     * 
     * Returns query with a list of all languages
     *
	 * @param boolean Use true for return only supported languages
     * @return mixed Query with all languages or supported languages
     */
	public function get_langs($supported = false){
		if($supported) return $this->query("SELECT * FROM LANG WHERE supported='1'");
		else return $this->query("SELECT * FROM LANG");
	}
	
	 /**
     * 
     * Get  a document by id.
     *
	 * @param int $id Document id 
     * @return array Array with all the document's info.
     */
	public function get_doc($id){
		$id = (int) $id;
		$doc = $this->query("SELECT * FROM DOCS WHERE id='$id'");
		if(!$doc) throw new Exception("Document couldn't be found");
		
		return @mysqli_fetch_array($doc);
	}
	
	/**
     * 
     * Get  ticket by id.
     *
	 * @param int $id Ticket id 
     * @return array Array with all the ticket's info.
     */
	public function get_ticket($id){
		$id = (int) $id;
		$ticket = $this->query("SELECT * FROM TICKETS WHERE id='$id'");
		return @mysqli_fetch_array($ticket);
	}
	
	/**
     * 
     * Get all user's tickets.
     *
	 * @param int $userid User id 
     * @return mixed Query with all user's tickets.
     */
	public function get_user_tickets($userid){
		$userid = (int) $userid;
		return $this->query("SELECT * FROM TICKETS WHERE userid='$userid' ORDER BY id DESC");
	}
	
	/**
     * 
     * Get all ticket's comments.
     *
	 * @param int $ticketid Ticket id 
     * @return mixed Query with all ticket's comments.
     */
	public function get_comments($ticketid){
		$ticketid = (int) $ticketid;
		return $this->query("SELECT * FROM COMMENTS WHERE ticketid='$ticketid' ORDER BY id ASC");
	}
	
	/**
     * 
     * Get all properties of an user/ticket/staff.
     *
	 * @param string $type It can be user, ticket or staff.
	 * @param int $id ID or the user/ticket/staff
     * @return mixed Query with all properties of the user/ticket/staff.
     */
	public function get_propvalues($type, $id){
		$id = (int) $id;
		if($type == "ticket") $string = "SELECT * FROM EXTRA WHERE type='propertyticket' AND toid='$id'";
		elseif($type == "user") $string = "SELECT * FROM EXTRA WHERE type='property' AND toid='$id'";
		elseif($type == "staff") $string = "SELECT * FROM EXTRA WHERE type='propertystaff' AND toid='$id'";
		return $this->query($string);
	}
	
	
	
	/**
     * 
     * Get staff user info by id.
     *
	 * @param int $id ID of the staff
     * @return array Array with all staff info.
     */
	public function get_staff($id){
		$id = (int) $id;
		$query = $this->query("SELECT * FROM STAFF WHERE id='$id'");
		if(!$query) throw new Exception("Staff user couldn't be found");
		return @mysqli_fetch_array($query);
	}
	
	/**
     * 
     * Get info of a single property.
     *
	 * @param string $by It can be by name or by id
	 * @param string $value It can be the name or the id
     * @return array Array with property's info.
     */
	public function get_property($by, $value){
		$by = $this->sql_escape($by);
		$value = $this->sql_escape($value);
		$query = $this->query("SELECT * FROM PROPERTIES WHERE $by='$value'");
		if (mysqli_num_rows($query) == 1) return @mysqli_fetch_array($query);
		else throw new Exception("Property is not unique");
	}
	
	/**
     * 
     * Get all the properties of a type and input.
     *
	 * @param string $type It can be user/tickets/staff
	 * @param string $input It can be the name or the id
     * @return mixed Query result of selection.
     */
	public function get_properties($type, $input = ""){
		if($type == "tickets" || $type == "user" || $type == "staff"){
			if($input == "")
				return $this->query("SELECT * FROM PROPERTIES WHERE type='$type'");
			elseif($input == "text" || $input == "checkbox" || $input == "select"){
				return $this->query("SELECT * FROM PROPERTIES WHERE type='$type' AND input='$input'");
			}
			else{
				throw new Exception("$input is not a valid input");
				return false;
			}
		}
		else{
			throw new Exception("$type is not a valid type");
			return false;
		}
	}
	
	/**
     * 
     * Delete a staff member by id.
     *
	 * @param int $id ID of the staff user
     * @return boolean True
     */
	public function delete_staff($id){
		$id = (int) $id;
		if(!$this->query("DELETE FROM STAFF WHERE id='$id'")) throw new Exception("Couldn't delete staff user");
		$this->query("DELETE FROM EXTRA WHERE type='propertystaff' AND toid='$id'");
		$this->query("DELETE FROM EXTRA WHERE type='filter' AND toid='$id'");
		return true;
	}
	
	
	/**
     * 
     * Change value of a staff user.
     *
	 * @param int $id ID of the staff user
	 * @param string $name Name of the parameter to modify
	 * @param string $value New value of the parameter to modify
     * @return mixed Mysqli result of the query UPDATE
     */
	public function update_staff($id, $name, $value){
		$id = (int) $id;
		$name = $this->sql_escape($name);
		$value = $this->sql_escape($value);
		return $this->query("UPDATE STAFF SET $name='$value' WHERE id='$id'");
	}
	
	/**
     * 
     * Change user's email.
     *
	 * @param int $id ID of the user
	 * @param string $new_email New Email
     * @return boolean True if everything ok, False if couln't update
     */
	public function update_user_email($id, $new_email){
		$id = (int) $id;
		$new_mail = $this->sql_escape($new_mail);
		if(!$this->query("UPDATE USERS SET email='$new_email' WHERE id='$id'")) return false;
		if(!$this->query("UPDATE TICKETS SET email='$new_email' WHERE userid='$id'")) return false;
		return true;
	}
	
	/**
     * 
     * Change user's name.
     *
	 * @param int $id ID of the user
	 * @param string $new_name New user's name
     * @return boolean True if everything ok, False if couln't update
     */
	public function update_user_name($id, $new_name){
		$id = (int) $id;
		$new_name = $this->sql_escape($new_name);
		if(!$this->query("UPDATE USERS SET name='$new_name' WHERE id='$id'")) return false;
		if(!$this->query("UPDATE COMMENTS SET username='$new_name' WHERE userid='$id'")) return false;
		return true;
	}
	
	/**
     * 
     * Change user's password.
	 * Function hashes the password by itself.
     *
	 * @param int $id ID of the user
	 * @param string $password New Password
     * @return boolean True if everything ok, False if couln't update
     */
	public function update_user_password($id, $password){
		$hash = crypt($password);
		$id = (int) $id;
		if($this->query("UPDATE USERS SET password='$hash' WHERE id='$id'")) return true;
		else return false;
	}
	
	/**
     * 
     * Change user's property.
     *
	 * @param int $id ID of the user
	 * @param string $propname Name of the property
	 * @param string $value New value of the property
	 * @param boolean $isstaff Is being updated by an staff member?
     * @return mixed Return query update result, False if couln't update
     */
	public function update_user_property($id, $propname, $value, $isstaff = false){
		$value = $this->sql_escape($value);
		$propname = $this->sql_escape($propname);
		$id = (int) $id;
		$prop = $this->get_property('name', $propname);
		if(!$propname[edit] && $isstaff == false) return false;
		else $this->query("UPDATE EXTRA set value='$value' WHERE name='$propname' AND type='property' AND toid='$id'");
	}
	
	/**
     * 
     * Change staff's property.
     *
	 * @param int $id ID of the staff user
	 * @param string $propname Name of the property
	 * @param string $value New value of the property
	 * @param boolean $isstaff Is being updated by an staff member?
     * @return mixed Return query update result, False if couln't update
     */
	public function update_staff_property($id, $propname, $value, $isstaff = false){
		$value = $this->sql_escape($value);
		$propname = $this->sql_escape($propname);
		$id = (int) $id;
		$prop = $this->get_property('name', $propname);
		if(!$propname[edit] && $isstaff == false) return false;
		else $this->query("UPDATE EXTRA set value='$value' WHERE name='$propname' AND type='property' AND toid='$id'");
	}
	
	/**
     * 
     * Update tickets department.
     *
	 * @param int $ticketid ID of ticket
	 * @param string $department New deparment of the ticket
     * @return boolean Return true;
     */
	public function update_ticket_deparment($ticketid, $department){
		$ticketid = (int) $ticketid;
		$department = $this->sql_escape($department);
		$this->query("UPDATE TICKETS SET department='$department' WHERE id='$ticketid'");
		return true;
	}
	
	
	/**
     * 
     * Deletes an user and all the properties.
     *
	 * @param int $id ID of the user
     * @return boolean Returns true.
     */
	public function delete_user($id){
		$id = (int) $id;
		$this->query("DELETE FROM USERS WHERE id='$id'");
		$this->query("DELETE FROM EXTRA WHERE type='property' AND toid='$id'");
		return true;
	}
	
	/**
     * 
     * Create a document. The function doesn't upload the file
     *
	 * @param string $title Title of the document
	 * @param string $content Content of the document
	 * @param string $author Name of the author
	 * @param string $finename Name of the file attached. Example: myfile.zip. It must be in /files/ folder. 
     * @return boolean Returns true.
     */
	public function create_doc($title, $content, $author, $filename = ''){
		if(strlen($title) < 5) return false;
		if(strlen($content) < 10) return false;
		$title = $this->sql_escape($title);
		$content = $this->sql_escape($content);
		$author = $this->sql_escape($author);
		$filename = $this->sql_escape($filename);
		$actual_date = date("j/m/y - H:i");
		$this->query("INSERT INTO `DOCS`(`id`, `title`, `content`, `by`, `date`, `file`) VALUES ('','$title','$content','$author','$actual_date','$filename')");
		return true;
	}
	
	/**
     * 
     * Update a field value of a document
     *
	 * @param int $id ID of the document
	 * @param string $field Field to update. It can be: title, content, by, date or file
	 * @param string $new_value New value of the field
     * @return boolean Returns true.
     */
	public function update_doc($id, $field, $new_value){
		$id = (int) $id;
		$field = $this->sql_escape($field);
		$new_value = $this->sql_escape($new_value);
		$this->query("UPDATE DOCS SET $field='$new_value' WHERE id='$id'");
		return true;
	}
	
	/**
     * 
     * Delete a document
     *
	 * @param int $id ID of the document
     * @return boolean Returns true.
     */
	public function delete_doc($id){
		$id = (int) $id;
		$this->query("DELETE FROM DOCS WHERE id='$id'");
		return true;
	}
	
	/**
     * 
     * Update ticket's property value
     *
	 * @param int $id Ticket ID
	 * @param string $propname Name of the property
	 * @param string $propvalue New value for the property
     * @return boolean Returns true.
     */
	public function edit_ticket_property($id, $propname, $propvalue){
		$id = (int) $id;
		$propname = $this->sql_escape($propname);
		$propvalue = $this->sql_escape($propvalue);
		$this->query("UPDATE EXTRA SET value='$propvalue' WHERE toid='$id' AND name='$propname' AND type='propertyticket'");
		return true;
	}
	
	
	/**
     * 
     * Create a new comment.
     *
	 * @param int $ticketid ID of the ticket.
	 * @param string $content Text of the comment
	 * @param int $userid ID of the user/staff who has made the comment
	 * @param string $username Name of the user/staff who has made the comment
	 * @param boolean $isstaff True if the comment has been made by a staff, false (default) if not.
     * @return boolean True if everything ok.
     */
	public function new_comment($ticketid, $content, $userid, $username, $isstaff = false){
		$bool = ($isstaff) ? 1 : 0;
		$actual_date = date("j/m/y - H:i");
		$query = sprintf("INSERT into COMMENTS(id,content,ticketid,isstaff,userid,username,date) VALUES('','%s','%s', $bool, '%s', '%s','$actual_date')", $this->sql_escape($content),(int) $ticketid, $this->sql_escape($userid),$this->sql_escape($username));
		if(strlen($content) < 5) return false;
		$this->query($query);
		return true;
	}
	
	/**
     * 
     * Marks a ticket as viewed.
     *
	 * @param int $ticketid ID of the ticket
     * @return boolean Return true
     */
	public function view_ticket($ticketid){
		$ticketid = (int) $ticketid;
		$this->query("UPDATE TICKETS SET isnew='0'WHERE id='$ticketid'");
		return true;
	}
	
	/**
     * 
     * Make a ticket belong to a staff.
     *
	 * @param int $ticketid ID of the ticket
	 * @param int $staffid ID of the staff
     * @return boolean Return true
     */
	public function own_ticket($ticketid, $staffid){
		$ticketid = (int) $ticketid;
		$staffid = (int) $staffid;
		$staff = $this->get_staff($staffid);
		$this->query("UPDATE TICKETS SET staffuser='$staff[user]' WHERE id='$ticketid'");
		$staff[tickets]++;
	 	$this->query("UPDATE STAFF SET tickets='$staff[tickets]' WHERE id='$staff[id]'");
		return true;
	}
	
	
	
	/**
     * 
     * Derivate a ticket.
     * The ticket won't belong to any staffuser
	 * 
	 * @param int $ticketid ID of the ticket.
     * @return boolean True if everything ok.
     */
	public function derivate($ticketid){
		$ticketid = (int) $ticketid;
		$ticket = $this->get_ticket($ticketid);
		$this->query("UPDATE TICKETS SET staffuser='', isnew='1', isclosed='0' WHERE id='$ticket[id]'");
		$staff = @mysqli_fetch_array($this->query("SELECT * FROM STAFF WHERE user='$ticket[staffuser]'"));
		$staff[tickets]--;
		$this->query("UPDATE STAFF SET tickets='$staff[tickets]' WHERE id='$staff[id]'");
		return true;
	}
	
	/**
     * 
     * Closes a ticket.
     * 
	 * @param int $ticketid ID of the ticket.
     * @return boolean True if everything ok.
     */
	public function close_ticket($ticketid){
		$ticketid = (int) $ticketid;
		$this->query("UPDATE TICKETS SET isclosed='1' WHERE id='$ticketid'");
		return true;
	}
	
	/**
     * 
     * Create a new staff member.
	 * Properties' array syntax:
	 * <code>
	 * $properties[name] = value // 'name' of the property and 'value'.
	 * </code>
	 * Filters' array syntax
	 * If the filter is boolean (value can be 1, 0 or both)
	 * <code>
	 * $filters[id] = value
	 * </code>
	 * If the filter is multiple options (you have multiples values)
	 * <code>
	 * $filters[id-op0] = value0; //value is true or false
	 * $filters[id-op1] = value1; //value is true or false
	 * $filters[id-op2] = value2; //value is true or false
	 * ...
	 * </code>
	 * 
     *
	 * @param string $name Name of the staff member.
	 * @param string $email Email of the staff member
	 * @param boolean $manage_users Can this staff manage users?
	 * @param boolean $docs Can this staff create docs?
	 * @param array $departments Array with departments for this member
	 * @param array $langs Array with languages for this member
	 * @param array $properties Array with properties values by name. Ex: $properties['propery name'] = 'property value';
	 * @param array $filters Array with filters values by id.
     * @return array Returns array with all staff data: username, id, password.
     */
	public function new_staff($name, $email, $manage_users, $docs, $departments, $langs, $properties, $filters){
		$staff = array();
		/*Get the last id*/
		$last = @mysqli_fetch_array($this->query("SELECT * FROM STAFF ORDER BY id DESC LIMIT 1"));
		$lid = $lastid[id]+1;
		$staff[username] = "staff".$lid;
		/*Generate Password*/
		$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ12345678901234567890";
 		$code = "";
 		for($i=0;$i<6;$i++) $code .= substr($str,rand(0,46),1);
		$staff[password] = $code;
		
		$muser = ($manage_users) ? 1 : 0;
		$mdocs = ($docs) ? 1 : 0;
		
		/*Create departments' string*/
		$dstring = implode(', ', $departments);
		
		/*Create languages' string*/
		$dlang = implode(', ', $langs);
		
		/*Hash password*/
		$hash = crypt($code);
		/*Create Staff User*/
		$this->query("INSERT into STAFF(id,name,user,pass,tickets,departments,manage,docs,langs,email) VALUES('','$name','$staff[username]','$hash','0','$dstring','$musers','$mdocs','$dlang','$email')");
		
		/*Select array*/
		$staff_array = @mysqli_fetch_array($this->query("SELECT * FROM STAFF WHERE user='$staff[username]' AND pass='$hash'"));
		
		/*Create Properties for the staff member*/
		$query = $this->query("SELECT * FROM PROPERTIES WHERE type='staff'");
			while($reg = @mysqli_fetch_array($query)){
				if(!isset($properties["$reg[name]"])){
					$provalue = str_replace(" ", "_", "$reg[name]");
					if(!isset($properties[$provalue])){
						$reg2 = @mysqli_fetch_array($this->query("SELECT * FROM EXTRA WHERE type='defaultproperty' AND name='$reg[name]'"));
						if($reg2[input] != "select"){
							$properties["$reg[name]"] = $reg2[value];
						}
						else{
							$array = explode("~", $reg2[value]);
							$properties["$reg[name]"] = $array[0];
						}
					}
				}else{
					$provalue = $reg[name];
				}
				$query2=sprintf("INSERT into EXTRA (id,name,value,type,plugin,toid) VALUES('','$reg[name]','%s','propertystaff','$reg[plugin]','$staff_array[id]')", $this->sql_escape($properties[$provalue]));	
				$this->query($query2);
			}
		/*Create Filters*/
		$query = $this->query("SELECT * FROM PROPERTIES WHERE filter='1'");
		while($filter = @mysqli_fetch_array($query)){
			if($filter[input] == "checkbox"){
				$value = $this->sql_escape($filters["$filter[id]"]);
				$this->query("INSERT into EXTRA(id,name,value,type,plugin,toid) VALUES('','$filter[name]','$value','filter','$filter[plugin]','$staff_array[id]')");
			}
			else if($filter[input] == "select"){
				$options_array = explode("~", $filter[value]);
	    		$lenght = count($options_array) - 1;
				$string = "";
				for($i=0; $i<$lenght; ++$i){
					if($filters["$filter[id]-op$i"]) $string .= $options_array[$i] . "~";
				}			
				$this->query("INSERT into EXTRA(id,name,value,type,plugin,toid) VALUES('','$filter[name]','$string','filter','$filter[plugin]','$staff_array[id]')");
			}
		}
		$staff[id] = $staff_array[id];
		return $staff;
	}
	
	/**
     * 
     * Create a new user.
	 * Properties' array syntax:
	 * <code>
	 * $properties[name] = value // 'name' of the property and 'value'.
	 * </code>
	 * 
     *
	 * @param string $name Name of the user.
	 * @param string $email Email of the user.
	 * @param string $pass password of the user.
	 * @param string $rpass password of the user.
	 * @param array $properties Array with properties values by name. Ex: $properties['propery name'] = 'property value';
     * @return array Returns array with all user data: email, id, hash.
     */
	public function new_user($name, $email, $pass, $rpass, $properties){
		$email = $this->sql_escape($email);
		$query = $this->query("SELECT * from USERS WHERE email='$email'");
		if(mysqli_num_rows($query) == 1) return false;
		elseif(!$this->validate_email($email)) return false;
		elseif($pass != $rpass) return false;
		elseif(strlen($pass) < 6) return false;
		else{
			$hash = crypt($pass);
			$query = sprintf("INSERT into USERS(id,name,email,password) VALUES('','%s','%s','%s')", $this->sql_escape($name),$email,$hash);
			if(!$this->query($query)) return false;
			
			$query = $this->query("SELECT * FROM USERS WHERE email='$email'");
			$user = @mysqli_fetch_array($query);
	
			$query = $this->query("SELECT * FROM PROPERTIES WHERE type='user'");
			while($reg = @mysqli_fetch_array($query)){
				if(!isset($properties["$reg[name]"])){
					$provalue = str_replace(" ", "_", "$reg[name]");
					if(!isset($properties[$provalue])){
						$reg2 = @mysqli_fetch_array($this->query("SELECT * FROM EXTRA WHERE type='defaultproperty' AND name='$reg[name]'"));
						if($reg2[input] != "select"){
							$properties["$reg[name]"] = $reg2[value];
						}
						else{
							$array = explode("~", $reg2[value]);
							$properties["$reg[name]"] = $array[0];
						}
					}
				}else{
					$provalue = $reg[name];
				}
				$query2=sprintf("INSERT into EXTRA (id,name,value,type,plugin,toid) VALUES('','$reg[name]','%s','property','$reg[plugin]','$user[id]')",$this->sql_escape($properties[$provalue]));	
				$this->query($query2);
			}
			return $user;
		}
	}

	/**
     * 
     * Get user's array by id 
     *
	 * @param int $id ID of the user
     * @return array Returns array with all user data.
     */
	public function get_user_by_id($id){
		$id = (int) $id;
		return @mysqli_fetch_array($this->query("SELECT * FROM USERS WHERE id='$id'"));
	}

	/**
     * 
     * Get user's select query result 
     *
	 * @param string $by It can be id or email
     * @return mixed returns query with user data.
     */
	public function get_user($by, $value, $isstaff = false){
		$by = $this->sql_escape($by);
		$value = $this->sql_escape($value);		
		if($isstaff) $query = $this->query("SELECT * FROM STAFF WHERE $by='$value");
		else $query = $this->query("SELECT * FROM USERS WHERE $by='$value");
		
		return $query;
	}
	
	/**
     * 
     * Create a new ticket.
	 * Properties' array syntax:
	 * <code>
	 * $properties[name] = value // 'name' of the property and 'value'.
	 * </code>
	 * 
     *
	 * @param string $department Name of the ticket's department.
	 * @param string $lang Language of the ticket.
	 * @param string $title Title of the ticket.
	 * @param string $message Message of the ticket.
	 * @param string $email Email of the user.
	 * @param string $name Name of the user.
	 * @param int $userid ID of the user.
	 * @param array $properties Array with properties values by name. Ex: $properties['propery name'] = 'property value';
     * @return array Returns array with all ticket's data.
     */
	public function new_ticket($department, $lang, $title, $message, $email, $name, $userid, $properties){
		$userid = (int) $userid;
		$title = $this->sql_escape($title);
		if(strlen($title) < 4){
			return false;
		}
		if(strlen($message) < 5){
			return false;
		}
		if($department != htmlentities($department)){
			return false;
		}
		$actual_date = date("j/m/y - H:i");
		
		$query = sprintf("INSERT into TICKETS(id,title,content,department,userid,email,isclosed,date,last,lang,staffuser,isnew) VALUES('','%s','%s','%s','%s','%s',0,'$actual_date','%s','$lang','','1')", $this->sql_escape($title), $this->sql_escape($message),$this->sql_escape($department), $userid,$this->sql_escape($email),$this->sql_escape($name));
		$this->query($query);
		
		$query = $this->query("SELECT * FROM TICKETS WHERE userid='$userid' ORDER BY id DESC LIMIT 1");
		$ticket = @mysqli_fetch_array($query);
		
		$query = $this->query("SELECT * FROM PROPERTIES WHERE type='tickets'");
			while($reg = @mysqli_fetch_array($query)){
				if(!isset($properties["$reg[name]"])){
					$provalue = str_replace(" ", "_", "$reg[name]");
					if(!isset($properties[$provalue])){
						$reg2 = @mysqli_fetch_array($this->query("SELECT * FROM EXTRA WHERE type='defaultproperty' AND name='$reg[name]'"));
						if($reg2[input] != "select"){
							$properties["$reg[name]"] = $reg2[value];
						}
						else{
							$array = explode("~", $reg2[value]);
							$properties["$reg[name]"] = $array[0];
						}
					}
				}else{
					$provalue = $reg[name];
				}
				$query2=sprintf("INSERT into EXTRA (id,name,value,type,plugin,toid) VALUES('','$reg[name]','%s','propertyticket','$reg[plugin]','$ticket[id]')",$this->sql_escape($properties[$provalue]));	
				$this->query($query2);
			}
		return $ticket;
	}
	
	/**
     * 
     * Login user
     *
	 * @param string $email Email of the user or Username of the staff
	 * @param string $pass Password of the user
 	 * @return array|boolean Returns array with all user's info or Retruns false if login is invalid.
     */
	public function login($email, $pass){
		$email = $this->sql_escape($email);
		$query = $this->query("SELECT * FROM USERS WHERE email='$email'");
		if (@mysqli_num_rows($query) == 1) {
			$user = @mysqli_fetch_array($query);
			$hash = crypt($pass, $user[password]);
			if($hash != $user[password]) return false;
			else return $user;
		}
		else {
			return false;
		}
	}
	
	/**
     * 
     * Login staff member
     *
	 * @param string $username Username of the staff member
	 * @param string $password Password of the staff member
 	 * @return array|boolean Returns array with all staff memeber's info or Retruns false if login is invalid.
     */
	public function login_staff($username, $password){
		$username = $this->sql_escape($username);
		$query = $this->query("SELECT * FROM STAFF WHERE user='$username'");
		if (@mysqli_num_rows($query) == 1) {
			$staff = @mysqli_fetch_array($query);
			$hash = crypt($password, $staff[pass]);
			if($hash != $staff[pass]) return false;
			else return $staff;
		}
		else {
			return false;
		}
	}
	
	/**
     * 
     * Adds a new Extra
     *
	 * @param string $name Name of the Extra
	 * @param string $value Value of the Extra
	 * @param string $type Type of the Extra
	 * @param int $toid An ID to link with the extra if it has.
	 * @param string $plugin Name of your plugin. If you aren't writting a plugin just use 'no'.
 	 * @return boolean returns true.
     */
	public function add_extra($name, $value, $type, $toid, $plugin = 'no'){
		$name = $this->sql_escape($name);
		$value = $this->sql_escape($value);
		$type = $this->sql_escape($type);
		$toid = (int) $toid;
		$plugin = $this->sql_escape($plugin);
		$this->query("INSERT into EXTRA(id,name,value,type,plugin,toid) VALUES('','$name','$value','$type','$plugin','$toid')");
		return true;
	}
	
	/**
     * 
     * Edit an extra value
     *
	 * @param string $new_value New Value of the extra
	 * @param string $type Type of extra
	 * @param string $by Parameter that you use to find it
	 * @param string $by_value Value of that parameter
 	 * @return boolean true
     */
	public function edit_extra($new_value, $type, $by, $by_value){
		$new_value = $this->sql_escape($new_value);
		$type = $this->sql_escape($type);
		$by = $this->sql_escape($by);
		$by_value = $this->sql_escape($by_value);
		$this->query("UPDATE EXTRA SET value='$new_value' WHERE type='$type' AND $by='$by_value'");
		return true;
	}
	
	/**
     * 
     * Gets extra query
     *
	 * @param string $type Type of extra
	 * @param string $by Parameter that you use
	 * @param string $value Value of that parameter
 	 * @return mixed Returns select query of the extra.
     */
	public function get_extra($type, $by, $value){
		$by = $this->sql_escape($by);
		$value = $this->sql_escape($value);
		$type = $this->sql_escape($type);
		
		$query = $this->query("SELECT * FROM EXTRA WHERE type='$type' AND $by='$value'");
		
		return $query;
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
	 * @param string $plugin Plugin name, default is no.
	 * @return boolean Returns true.
     */
	public function new_property($name, $iseditable, $type, $input, $value, $filter, $plugin = 'no'){
		$name = $this->sql_escape($name);
		$iseditable = ($iseditable) ? 1 : 0;
		$type = $this->sql_escape($type);
		$input = $this->sql_escape($input);
		$filter = ($filter) ? 1 : 0;
		if(mysqli_num_rows($this->query("SELECT * FROM PROPERTIES WHERE name='$name'")) > 0){
			throw new Exception("Property already exists");
		}
		if($input == 'select'){
			if(!is_array($value)) return false;
			$str = "";
			$limit = count($value);
			for($i=0;$i<$limit;++$i){
				$str .= $value[$i] . "~";
			}
			$str = $this->sql_escape($str);
			if(!$this->query("INSERT into PROPERTIES(id,plugin,name,type,value,edit,input,filter) VALUES('','$plugin','$name', '$type', '$str','$edit','select','$filter')")) return false;
		}else{
			$value = $this->sql_escape($value);
			if(!$this->query("INSERT into PROPERTIES(id,plugin,name,type,value,edit,input,filter) VALUES('','$plugin','$name', '$type', '$value','$edit','$input','$filter')")) return false;
		}
		
		//Add property to all
		if($type == 'user')
			$query = $this->query("SELECT * FROM USERS");
		elseif($type == 'staff')
			$query = $this->query("SELECT * FROM STAFF");
		elseif($type == 'tickets')
			$query = $this->query("SELECT * FROM TICKETS");
	
		if($input != "select"){
			if($type == 'user')
				while($reg = @mysqli_fetch_array($query)) $this->add_extra($name, $value, 'property', $reg[id], 'no');		
			elseif($type == 'staff')
				while($reg = @mysqli_fetch_array($query)) $this->add_extra($name, $value, 'propertystaff', $reg[id], 'no');
			elseif($type == 'tickets')
				while($reg = @mysqli_fetch_array($query)) $this->add_extra($name, $value, 'propertyticket', $reg[id], 'no');
		}else{
			if($type == 'user')
				while($reg = @mysqli_fetch_array($query)) $this->add_extra($name, $value[0], 'property', $reg[id], 'no');		
			elseif($type == 'staff')
				while($reg = @mysqli_fetch_array($query)) $this->add_extra($name, $value[0], 'propertystaff', $reg[id], 'no');
			elseif($type == 'tickets')
				while($reg = @mysqli_fetch_array($query)) $this->add_extra($name, $value[0], 'propertyticket', $reg[id], 'no');
		}
		return true;
	}

	/**
     * 
     * Edit Property
     *
	 * @param int $id ID of the property
	 * @param string $new_name New name of the property
	 * @param boolean $edit Is editable?
	 * @param string|array $value If property is checkbox (1 or 0) or text, set the default value here. If it is select, set an array with options. Ex: $value[0] = 'first option'; $value[1] = 'second option';
 	 * @return boolean Return true.
     */
	public function edit_property($id, $new_name, $edit, $value){
		$id = (int) $id;
		$edit = ($edit) ? 1 : 0;
		$prop = $this->get_property('id', $id);
		$new_name = $this->sql_escape($new_name);
		
		if($new_name != $prop[name]){
		if(mysql_num_rows($this->query("SELECT * FROM PROPERTIES WHERE name='$new_name'"))) return false;
			$this->query("UPDATE PROPERTIES SET name='$new_name' WHERE id='$prop[id]'");
			$this->query("UPDATE EXTRA SET name='$new_name' WHERE name='$prop[name]' AND (type='property' OR type='propertytickets' OR type='propertystaff')");
		}
		
		if($prop[input] == "select"){
			if(!is_array($value)) throw new Exception("value is not an array and you have a select property");
			$str = "";
			$limit = count($value);
			for($i=0;$i<$limit;++$i){
				$str .= $value[$i] . "~";
			}
			$str = $this->sql_escape($str);
			$this->query("UPDATE PROPERTIES SET value='$str' WHERE id='$prop[id]'");
		} else if($value != $prop[value]){
			if(is_array($value)) throw new Exception("value is an array and you don't have a select property");
			$value = $this->sql_escape($value);
			$this->query("UPDATE PROPERTIES SET value='$value' WHERE id='$prop[id]'");
		}
		
		if($edit != $prop[edit]){
			$this->query("UPDATE PROPERTIES SET edit='$edit' WHERE id='$prop[id]'");
		}
		return true;
	}
	
	/**
     * 
     * Creates a new filter
     *
	 * @param int $propid ID of the property
	 * @param string|array $def If Filter is based in a checkbox set 1, 0 or 'both'. If filter is based in a select set an array with valid values. Ex: $def[0] = 'first value'; $def[1] = 'second value'
	 * @param boolean $iseditable Is the filter editable by the staff?.
	 * @return boolean Returns true.
     */
	public function create_filter($propid, $def, $iseditable){
		$id = (int) $propid;
		$prop = $this->get_property('id', $id);
		$this->query("UPDATE PROPERTIES SET filter='1' WHERE id='$id'");
		$query = $this->query("SELECT * FROM STAFF");
		if($prop[input] == "checkbox"){
			$str = $this->sql_escape($def);
			while($reg = @mysqli_fetch_array($query))
				$this->add_extra($prop[name], $str, 'filter', $reg[id], 'no');
		}elseif($prop[input] == "select"){
			if(!is_array($def)) throw new Exception("def is not an array and the property is select type");
			$max = count($def);
			$str = '';
			for($i=0; $i<$max; ++$i)
					$srt .= $def[$i]."~";
			while($reg = @mysqli_fetch_array($query))
				$this->add_extra($prop[name], $str, 'filter', $reg[id], 'no');			
		}
		if($iseditable)
			$this->add_extra($prop[name], $str, 'defaultfilter', '1', 'no');
		else
			$this->add_extra($prop[name], $str, 'defaultfilter', '0', 'no');		
		return true;
	}
	
	/**
     * 
     * Edit filter
     *
	 * @param string $name Name of the filter
	 * @param int $toid ID of the staff member
	 * @param string|array $value  If filter is based in a checkbox set 1, 0 or 'both'. If filter is based in a select set an array with valid values. Ex: $def[0] = 'first value'; $def[1] = 'second value'
	 * @return boolean Returns true.
     */
	public function edit_filter($name, $toid, $value){
		$name = $this->sql_escape($name);
		$id = $this->sql_escape($toid);
		$query = $this->query("SELECT * FROM EXTRA WHERE name='$name' AND type='defaultfilter'");
		if(!$query) return false;
		
		$filter = @mysqli_fetch_array($query);
		
		$prop = $this->get_property('name', $name);
		
		if($prop[input] == "checkbox"){
			$value = $this->sql_escape($value);
			$this->query("UPDATE EXTRA SET value='$value' WHERE name='$name' AND type='filter' AND toid='$id'");
			return true;
		} else if($prop[input] == "select"){
			if(!is_array($value)) throw new Exception("value is not an array and the property is select type");
			$str = '';
			foreach($value as $select_val)
					$str .= $select_val."~";
			
			$this->query("UPDATE EXTRA SET value='$str' WHERE name='$name' AND type='filter' AND toid='$id'");
			return true;
		}
	}
	
	/**
     * 
     * Delete filter
     *
	 * @param int $filterid ID of the filter to delete
	 * @return boolean Returns true.
     */
	public function delete_filter($filterid){
		$filterid = (int) $filterid;
		$prop = $this->get_property('id', $filterid);
		$this->query("UPDATE PROPERTIES SET filter='0' WHERE id='$filterid'");
		$this->query("DELETE FROM EXTRA WHERE name='$prop[name]' AND type='filter'");
		$this->query("DELETE FROM EXTRA WHERE name='$prop[name]' AND type='defaultfilter'");
		return true;
	}

	/**
     * 
     * Delete property
     *
	 * @param int $propid ID of the property to delete
	 * @return boolean Returns true.
     */
	public function delete_property($propid){
		$id = (int) $propid;
		$prop = $this->get_property('id', $id);
		$this->query("DELETE FROM EXTRA WHERE name='$prop[name]'");
		$this->query("DELETE FROM PROPERTIES WHERE id='$prop[id]'");
		return true;
	}
	
	/**
     * 
     * Edit propery of staff
     *
	 * @param string $propname Name of the property
	 * @param string $value Value of the property
	 * @param boolean $isadmin Is being edited by an admin? Default is true
	 * @return boolean Returns true if success. If don't, returns false.
     */
	public function edit_staff_prop($propname, $value, $staffid, $isadmin = true){
		$name = $this->sql_escape($propname);
		$value = $this->sql_escape($value);
		$id = (int) $staffid;
		$prop = $this->get_property('name', $name);
		if(!$prop[edit] && $isadmin == false) return false;
		else{
			$this->query("UPDATE EXTRA SET value='$value' WHERE name='$name' AND type='propertystaff' AND toid='$id'");
			return true;
		}
	}
	
	
	/**
     * 
     * Get installed plugins list.
     *
	 * @return mixed Retruns query result with all plugins.
     */
	public function plugin_list(){
		return $this->query("SELECT * FROM PLUGINS ORDER BY id");
	}
	
	/**
     * 
     * Get a plugin by name.
     *
	 * @param int $name Name of the plugin
	 * @return array/boolean Returns array with plugin's info if it exists. If plugin doesn't exists, returns false
     */
	public function get_plugin($name){
		$name = $this->sql_escape($name);
		$query = $this->query("SELECT * FROM PLUGINS WHERE name='$name'");
		if($query)
			return mysqli_fetch_array($query);
		else
			return false;
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
	 * @param string $plugin Name of your plugin. If you are not writing a plugin, use 'no'
	 * @return array Retruns array with all text info.
     */
	public function add_text($title, $content, $type, $lang, $plugin){
		$title = $this->sql_escape($title);
		$lang = $this->sql_escape($lang);
		$type = $this->sql_escape($type);
		$content = $this->sql_escape($content);
		$plugin = $this->sql_escape($plugin);
		$this->query("INSERT into TEXT(id,name,value,lang,type,plugin) VALUES('','$title','$content','$lang','$type','$plugin')");
		return $last = @mysqli_fetch_array($this->query("SELECT * FROM TEXT ORDER BY id DESC LIMIT 1"));
	}
	
	/**
     * 
     * Edit a text value
     *
	 * @param string $name Title of the text
	 * @param string $content New content of the text
	 * @param string $lang Language of the text
	 * @return boolean Retruns true.
     */
	public function text_edit($name, $content, $lang){
		$name = $this->sql_escape($name);
		$content = $this->sql_escape($content);
		$lang = $this->sql_escape($lang);
		$this->query("UPDATE TEXT SET value='$content' WHERE name='$name' AND lang='$lang'");
		return true;
	}
	
	/**
     * 
     * Get all modes from a route.
     *
	 * @param string $route Route to search
	 * @return mixed Query result with all the modes for the route.
     */
	public function get_modes($route){
		$route = $this->sql_escape($route);
		return $this->query("SELECT * FROM MODES WHERE route='$route'");
	}
	
	/**
     * 
     * Get a mode array.
     *
	 * @param int $id ID of the game
	 * @return array Array with all mode's info.
     */
	public function get_mode($id){
		$id = (int) $id;
		$query = $this->query("SELECT * FROM MODES WHERE id='$id'");
		return @mysqli_fetch_array($query);
	}
	
	/**
     * 
     * Get codes from a specific route.
     *
	 * @param string $route Code route
	 * @param boolean $arstart Will the code be added to the start or the route? 
	 * @return array Array with all the files to include.
     */
	public function get_codes($route, $atstart){
		$atstart = ($atstart) ? 1 : 0;
		$route = $this->sql_escape($route);
		$query = $this->query("SELECT * FROM CODE WHERE route='$route' AND atstart='$atstart'");
		$arr = array();
		while($reg = @mysqli_fetch_array($query)){
			$arr[] = $reg['plugin'] . '/' . $reg['file'];
		}
		return $arr;
	}
	
	/**
     * 
     * Verify if an string is an email or not.
     *
	 * @param string $email Email to validate
	 * @return boolean Retruns true if $email is a email. Returns false if don't.
     */
	public function validate_email($email){
		if (!ereg("^([a-zA-Z0-9._]+)@([a-zA-Z0-9.-]+).([a-zA-Z]{2,4})$",$email)){ 
    	      return false; 
 		} else { 
		 	if(strlen($email) < 6) return false;
 		 	else return true; 
 		} 
	}
	
	/**
     * 
     * Send an email
     *
	 * @param string $email Email of the receiver
	 * @param string $title Title of the email
	 * @param string $message Message of the email
	 * @return boolean Retruns true.
     */
	public function mailto($email, $title,$message){
		$DATA = $this->get_data();
		$title .= "- $DATA[title]";
		$headers = array();
		$headers[] = "MIME-Version: 1.0";
		$headers[] = "Content-type: text/html";
		$headers[] = "From: ".$DATA[title]." - Support Center <$DATA[mainmail]>";
		$headers[] = "Reply-To: $DATA[title] - Support Center <$DATA[mainmail]>";
		$headers[] = "X-Mailer: PHP/".phpversion();
		
		mail($email, $title, $message, implode("\r\n", $headers));
	}
	
	/**
     * 
     * Make a log.
     *
	 * @param string $text Text of the log
	 * @return boolean Retruns true.
     */
	public function logs($text){
		$text = $this->sql_escape($text);
		$actual_date = date("j/m/y - H:i");
		$this->query("INSERT into LOGS(id,data,date) VALUES('','$text','$actual_date')");		
		return true;
	}
	
	/**
     * 
     * Make a log for a staff member.
     *
	 * @param string $staffuser Username of the staff member
	 * @param string $text Text of the log
	 * @return boolean Retruns true.
     */
	public function staff_logs($staffuser, $text){
		$staffuser = $this->sql_escape($staffuser);
		$text = $this->sql_escape($text);
		$actual_date = date("j/m/y - H:i");
		$this->query("INSERT into STAFFLOG(id,user,log,date) VALUES('','$staffuser','$text','$actual_date')");		
		return true;
	}
	
	/**
     * 
     * Make a SQL query.
     *
	 * @param string $string String with the query
	 * @return mixed Returns the query result
     */
	public function query($string){
		return mysqli_query($this->conexion, $string);
	}
	
	/**
     * 
     * Anti SQL-injection
     *
	 * @param string $thing String to verify
	 * @return string Returns same string but with Anti SQL-injection filter.
     */
	public function sql_escape($thing, $type='string'){
		return mysqli_real_escape_string($this->conexion, $thing);
	}
}
?>