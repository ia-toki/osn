<?php

function getMedalClass($medal) {
  if (!$medal) {
    return '';
  }
  $map = array('G' => 'gold', 'S' => 'silver', 'B' => 'bronze');
  $clazz = $map[$medal];
  if (!$clazz) {
    return '';
  }
  return 'medal--' . $clazz;
}

function getMedalName($medal) {
  if (!$medal) {
    return '';
  }
  $map = array('G' => 'Emas', 'S' => 'Perak', 'B' => 'Perunggu');
  return $map[$medal];
}
