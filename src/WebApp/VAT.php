<?php

namespace WebApp;

class VAT {

	public static function vatFromTotal($total, $vatRate) {
		if ($vatRate >= 1) $vatRate = $vatRate/100;
		return $total * $vatRate / (1 + $vatRate);
	}

	public static function vatFromNet($net, $vatRate) {
		if ($vatRate >= 1) $vatRate = $vatRate/100;
		return $vatRate * $net;
	}

	public static function netFromTotal($total, $vatRate) {
		if ($vatRate >= 1) $vatRate = $vatRate/100;
		return $total / (1 + $vatRate);
	}

	public static function grossFromNet($net, $vatRate) {
		if ($vatRate >= 1) $vatRate = $vatRate/100;
		return $net + $vatRate * $net;
	}

}
