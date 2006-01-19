<?php
/***************************************************************************
 *   Copyright (C) 2004-2005 by Konstantin V. Arkhipov                     *
 *   voxus@gentoo.org                                                      *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 *                                                                         *
 ***************************************************************************/
/* $Id$ */

	/**
	 * Wrapper around given childs of LogicalObject with custom logic-glue's.
	**/
	final class LogicalChain implements LogicalObject
	{
		private $chain = array();
		private $logic = array();
		
		public function expAnd(LogicalObject $exp)
		{
			return $this->exp($exp, Expression::LOGIC_AND);
		}
		
		public function expOr(LogicalObject $exp)
		{
			return $this->exp($exp, Expression::LOGIC_OR);
		}
		
		public function union(SelectQuery $query)
		{
			return $this->exp($query, LogicalExpression::UNION);
		}
		
		public function unionAll(SelectQuery $query)
		{
			return $this->exp($query, LogicalExpression::UNION_ALL);
		}
		
		public function intersect(SelectQuery $query)
		{
			return $this->exp($query, LogicalExpression::INTERSECT);
		}
		
		public function intersectAll(SelectQuery $query)
		{
			return $this->exp($query, LogicalExpression::INTERSECT_ALL);
		}
		
		public function except(SelectQuery $query)
		{
			return $this->exp($query, LogicalExpression::EXCEPT);
		}
		
		public function exceptAll(SelectQuery $query)
		{
			return $this->exp($query, LogicalExpression::EXCEPT_ALL);
		}
		
		private function exp(DialectString $exp, $logic)
		{
			$this->chain[] = $exp;
			$this->logic[] = $logic;
			
			return $this;
		}
		
		public function getSize()
		{
			return sizeof($this->chain);
		}
		
		public function toString(Dialect $dialect)
		{
			if ($this->chain) {
				$out = "({$this->chain[0]->toString($dialect)} ";
	
				for ($i = 1, $size = sizeof($this->chain); $i < $size; $i++)
					$out .= "{$this->logic[$i]} {$this->chain[$i]->toString($dialect)} ";
	
				return $out.')';
			}
			
			return null;
		}
		
		public function toBoolean(Form $form)
		{
			$chain = &$this->chain;
			
			$out = null;
			
			for ($i = 0, $size = sizeof($chain); $i < $size; $i++) {
				if (isset($chain[$i + 1]))
					$out =
						Expression::toBoolean(
							$this->logic[$i + 1],
							$chain[$i]->toBoolean($form),
							$chain[$i + 1]->toBoolean($form)
						);
				else
					$out =
						Expression::toBoolean(
							$this->logic[$i],
							$out,
							$chain[$i]
						);
			}
			
			return $out;
		}
	}
?>