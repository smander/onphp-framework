<?php
/***************************************************************************
 *   Copyright (C) 2005-2007 by Konstantin V. Arkhipov                     *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 *                                                                         *
 ***************************************************************************/
/* $Id$ */

	/**
	 * Widely used assertions.
	 * 
	 * @ingroup Base
	**/
	final class Assert extends StaticFactory
	{
		public static function isTrue($boolean, $message = null)
		{
			if ($boolean !== true)
				throw new WrongArgumentException(
					$message.', '.self::dumpArgument($boolean)
				);
		}
		
		public static function isFalse($boolean, $message = null)
		{
			if ($boolean !== false)
				throw new WrongArgumentException(
					$message.', '.self::dumpArgument($boolean)
				);
		}
		
		public static function isNull($variable, $message = null)
		{
			if ($variable !== null)
				throw new WrongArgumentException(
					$message.', '.self::dumpArgument($variable)
				);
		}

		public static function isNotNull($variable, $message = null)
		{
			if ($variable === null)
				throw new WrongArgumentException($message);
		}

		public static function isArray($variable, $message = null)
		{
			if (!is_array($variable))
				throw new WrongArgumentException(
					$message.', '.self::dumpArgument($variable)
				);
		}

		public static function isInteger($variable, $message = null)
		{
			if (
				!(
					is_numeric($variable)
					&& $variable == (int) $variable
				)
			)
				throw new WrongArgumentException(
					$message.', '.self::dumpArgument($variable)
				);
		}
		
		public static function isPositiveInteger($variable, $message = null)
		{
			if (
				!self::checkInteger($variable)
				|| $variable < 0
			)
				throw new WrongArgumentException(
					$message.', '.self::dumpArgument($variable)
				);
		}

		public static function isFloat($variable, $message = null)
		{
			if (
				!(
					$variable == (float) $variable
					&& is_numeric($variable)
				)
			)
				throw new WrongArgumentException(
					$message.', '.self::dumpArgument($variable)
				);
		}

		public static function isString($variable, $message = null)
		{
			if (!is_string($variable))
				throw new WrongArgumentException(
					$message.', '.self::dumpArgument($variable)
				);
		}
		
		public static function isBoolean($variable, $message = null)
		{
			if (!($variable === true || $variable === false))
				throw new WrongArgumentException(
					$message.', '.self::dumpArgument($variable)
				);
		}

		public static function isTernaryBase($variable, $message = null)
		{
			if (
				!(
					($variable === true)
					|| ($variable === false)
					|| ($variable === null)
				)
			)
				throw new WrongArgumentException(
					$message.', '.self::dumpArgument($variable)
				);
		}

		public static function brothers($first, $second, $message = null)
		{
			if (get_class($first) !== get_class($second))
				throw new WrongArgumentException(
					$message.', '.self::dumpOppositeArguments($first, $second)
				);
		}
		
		public static function isEqual($first, $second, $message = null)
		{
			if ($first !== $second)
				throw new WrongArgumentException(
					$message.', '.self::dumpOppositeArguments($first, $second)
				);
		}
		
		public static function isInstance($first, $second, $message = null)
		{
			if (!ClassUtils::isInstanceOf($first, $second))
				throw new WrongArgumentException(
					$message.', '.self::dumpOppositeArguments($first, $second)
				);
		}
		
		public static function isUnreachable($message = 'unreachable code reached')
		{
			throw new WrongArgumentException($message);
		}
		
		/// exceptionless methods
		//@{
		public static function checkInteger($value)
		{
			return (
				is_numeric($value)
				&& ($value == (int) $value)
				&& (strlen($value) == strlen((int) $value))
			);
		}
		
		public static function dumpArgument($argument)
		{
			return 'argument: ['.var_export($argument, true).']';
		}
		
		public static function dumpOppositeArguments($first, $second)
		{
			return
				'arguments: ['.var_export($first, true).'] '
				.'vs. ['.var_export($second, true).'] ';
		}
		//@}
	}
?>