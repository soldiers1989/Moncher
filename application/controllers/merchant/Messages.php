<?php 
header("Content-type: text/html; charset=utf-8");
require_once (dirname(dirname(dirname(__FILE__)))."/libraries/Includes.php");
class Messages extends CI_Controller {	
#.引用属性，每个控制器都需要有	
private $includes;	
/**	
public function __construct(){ 	
/**	
public function index(){ 
/** 
public function update(){ 
/**
public function search(){ 
/**
public function check(){
}