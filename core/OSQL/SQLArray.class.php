<?php
/***************************************************************************
 *   Copyright (C) 2005 by Konstantin V. Arkhipov                          *
 *   voxus@shadanakar.org                                                  *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 *                                                                         *
 ***************************************************************************/
/* $Id$ */

	class SQLArray implements DialectString
	{
		private $array = array();
		
		public function __construct($array)
		{
			$this->array = $array;
		}
		
		public function toString(Dialect $dialect)
		{
			$array = $this->array;

			if (is_array($array)) {
				$qouted = array();

				foreach ($array as $item)
					$quoted[] = $dialect->quoteValue($item);
				
				$value = implode(', ', $quoted);
			} else
				$value = $dialect->quoteValue($array);
			
			return "({$value})";
		}
	}
?>