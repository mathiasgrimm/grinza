<?php
//
///**
// * Checks is all elements from $actual exist in $valid
// *
// * @param array $valid
// * @param array|null $actual
// * @return bool
// */
//function grinza_array_in_array(array $valid, array $actual = null)
//{
//    if ($actual) {
//        foreach (array_keys($actual) as $k) {
//            if (!isset($valid[$k])) {
//                return false;
//            }
//        }
//
//        return true;
//    }
//}
//
//function grinza_validate_array_param_valid(array $valid, array $actual = null)
//{
//    if ($actual) {
//        if (!grinza_array_in_array($valid, $actual)) {
//            throw new InvalidArgumentException("Invalid index. Valid indexes: " . implode(', ', $valid));
//        }
//    }
//}
//
//
//
//
