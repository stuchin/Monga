<?php
/**
 * Monga is a swift MongoDB Abstraction for PHP 5.3+
 *
 * @package    Monga
 * @version    1.0
 * @author     Frank de Jonge
 * @license    MIT License
 * @copyright  2011 - 2012 Frank de Jonge
 * @link       http://github.com/FrenkyNet/Monga
 */

use Monga\Connection;

class Monga
{
	
	/**
	 *   
	 *  
	 */
	public static function init(array $options= null)
	{

	\Config::load('db', true);
        
        $db_config = \Config::get('db');

        $mongo_dns = $db_config['mongo_dns'];
        
        // get name database
	$namedatabase = substr(strrchr($mongo_dns, DS), 1);
        
        //$options  = array('connect' =>TRUE  );
	if (is_array($options)) 
        $connection = self::connection($mongo_dns,$options);
        else $connection = self::connection($mongo_dns);

         // Get the database
        $GLOBALS["database"] = $connection->database($namedatabase);
         
	}
		
	
	/**
	 * Returns a MongoBinData object
	 *
	 * @param   string  $data  data
	 * @param   int     $type  data type
	 * @return  object  MongoBinData
	 */
	public static function data($data, $type = null)
	{
		$type === null and $type = MongoBinData::BYTE_ARRAY;

		return new MongoBinData($data, $type);
	}

	/**
	 * Create a MongoId object
	 *
	 * @param   string  $id  id string
	 * @return  object  MongoId
	 */
	public static function id($id)
	{
		return new MongoId($id);
	}

	/**
	 * Create a MongoCode object
	 *
	 * @param   string  $code   javascript string
	 * @param   array   $scope  function scope
	 * @return  object  MongoCode
	 */
	public static function code($code, $scope = array())
	{
		return new MongoCode($code, $scope);
	}

	/**
	 * Create a MongoDate object
	 *
	 * @param   int     $sec   timestamp
	 * @param   int     $usec
	 * @return  object  MongoDate
	 */
	public static function date($sec = null, $usec = 0)
	{
		$sec === null and $sec = time();

		return new MongoDate($sec, $usec);
	}

	/**
	 * Create MongoRegex object
	 *
	 * @param   string  $regex  regex
	 * @return  object  MongoRegex
	 */
	public static function regex($regex)
	{
		return new MongoRegex($regex);
	}

	/**
	 * Create a Monga\Connection object
	 *
	 * @param   string   $server   server dns
	 * @param   array    $options  connection options
	 * @return  object   Monga\Connection
	 */
	public static function connection($server = null, array $options = array())
	{
		return new Connection($server, $options);
	}
}
