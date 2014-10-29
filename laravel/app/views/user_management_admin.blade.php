@extends('user_management')

@section('form')
  <?php

				$tmp=unserialize(Cookie::get('user',null));
				$user=Admin::getFromID($tmp->getID());
				?>
				<div class="form-group">
              <input type="hidden" class="form-control" id="id" name="id" value="{{$user->getID()}}">
              <label class="col-sm-2 control-label">username</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="username" name="username" disabled value="{{$user->getUsername()}}">
              </div>
            </div>
			<div class="form-group">
              <label class="col-sm-2 control-label">คำนำหน้าชื่อ</label>
              <div class="col-sm-4">
                <input type="text" id="title" name="title"  class="form-control"  value="{{$user->getTitle()}}">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">ชื่อ</label>
              <div class="col-sm-4">
                <input type="text" id="name" name="name" class="form-control"  value="{{$user->getName()}}">
              </div>
              <label class="col-sm-2 control-label">นามสกุล</label>
              <div class="col-sm-4">
                <input type="text" id="surname" name="surname" class="form-control"  value="{{$user->getSurname()}}">
              </div>
            </div>	
			<div class="form-group">
              <label class="col-sm-2 control-label">E-mail</label>
              <div class="col-sm-4">
                <input type="text" id="email" name="email" class="form-control"  value="{{$user->getEmail()}}">
              </div>
            </div>
			<div class="form-group">
              <label class="col-sm-2 control-label">โทรศัพท์</label>
              <div class="col-sm-4">
                <input type="text" id="telephone" name="telephone"  class="form-control"  value="{{$user->getTelephone()}}">
              </div>
            </div>
			<div class="form-group">
              <label class="col-sm-2 control-label">ตำแหน่ง</label>
              <div class="col-sm-4">
                <input type="text" id="position" name="position"  class="form-control"  value="{{$user->getPosition()}}">
              </div>
            </div>	
@stop