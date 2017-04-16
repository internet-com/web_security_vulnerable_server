<?php

  // Will perform all actions necessary to log in the user
  // Also protects user from session fixation.
  function log_in_user($user) {
    session_regenerate_id();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['last_login'] = time();
    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
    return true;
  }

  // A one-step function to destroy the current session
  function destroy_current_session() {
    // TODO destroy the session file completely
  }

  // Performs all actions necessary to log out a user
  function log_out_user() {
    unset($_SESSION['user_id']);
    destroy_current_session();
    return true;
  }

  // Determines if the request should be considered a "recent"
  // request by comparing it to the user's last login time.
  function last_login_is_recent() {
    $recent_limit = 60 * 60 * 24 * 1; // 1 day
    if(!isset($_SESSION['last_login'])) { return false; }
    return (($_SESSION['last_login'] + $recent_limit) >= time());
  }

  // Checks to see if the user-agent string of the current request
  // matches the user-agent string used when the user last logged in.
  function user_agent_matches_session() {
    if(!isset($_SERVER['HTTP_USER_AGENT'])) { return false; }
    if(!isset($_SESSION['user_agent'])) { return false; }
    return ($_SERVER['HTTP_USER_AGENT'] === $_SESSION['user_agent']);
  }

  // Inspects the session to see if it should be considered valid.
  function session_is_valid() {
    if(!last_login_is_recent()) { return false; }
    if(!user_agent_matches_session()) { return false; }
    return true;
  }

  // is_logged_in() contains all the logic for determining if a
  // request should be considered a "logged in" request or not.
  // It is the core of require_login() but it can also be called
  // on its own in other contexts (e.g. display one link if a user
  // is logged in and display another link if they are not)
  function is_logged_in() {
    // Having a user_id in the session serves a dual-purpose:
    // - Its presence indicates the user is logged in.
    // - Its value tells which user for looking up their record.
    if(!isset($_SESSION['user_id'])) { return false; }
    if(!session_is_valid()) { return false; }
    return true;
  }

  // Call require_login() at the top of any page which needs to
  // require a valid login before granting acccess to the page.
  function require_login() {
    if(!is_logged_in()) {
      destroy_current_session();
      redirect_to(url_for('/staff/login.php'));
    } else {
      // Do nothing, let the rest of the page proceed
    }
  }
	
	function generate_strong_password() {
		// each type of element is saved in a different array;
		$elements = array();
		$elements[] = 'abcdefghjkmnpqrstuvwxyz';
		$elements[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
		$elements[] = '0123456789';
		$elements[] = '\|""!@#$%&*?``~^()-_+{=}[.]><,:;';
		
		$all_possible_elements = '';
		$strong_password = '';
		
		// from each array a random element is taken an put into password, the rest of the elements are appended to a string containing all elements;
		foreach($elements as $element_type) {
			$strong_password .= $element_type[array_rand(str_split($element_type))];
			$all_possible_elements .= $element_type;
		}		
		
		for ($i = 0; $i < 8; $i ++) {
			$strong_password .= $all_possible_elements[array_rand(str_split($all_possible_elements))];
		}
		return str_shuffle($strong_password);
	}
	
	//returns random 22 char string
	function random_string($length=22) {
    // random_bytes requires an integer larger than 1
    $length = max(1, (int) $length);
    // generates a longer string than needed
    $rand_str = base64_encode(random_bytes($length));
    // substr cuts it to the correct size
    return substr($rand_str, 0, $length);
  }
	
	// hashes passwords using bcrypt only options available are cost and salt;
	function my_password_hash($password, $algo, $options = array()) {
		if ($algo == 1) {
			$hash = '';
			if (empty($options)) {
				$hash_format = "$2y$10$";
				$salt = strtr(random_string(22), '+', '.');
				$hash = crypt($password, $hash_format.$salt);
			} else if (isset($options['cost'])) {
					$hash_format = "$2y$".$options['cost']."$";
					if (isset($options['salt'])) {
						$hash = crypt($password, $hash_format.$options['salt']);
					} else {
						$salt = strtr(random_string(22), '+', '.');
						$hash = crypt($password, $hash_format.$salt);
					}
			}
			if($hash != '*0' || $hash != '') {
				return $hash;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	// verifies password entered and password hash in db match.
	function my_password_verify($password, $hash) {
		$cost = substr($hash, 4,2);
		$salt = substr($hash, 7,22);
		$new_hash = my_password_hash($password, PASSWORD_DEFAULT, ['cost' => $cost, 'salt' => $salt]);
		if($new_hash === $hash) {
			return true;
		} else {
			return false;
		}
	}

?>
