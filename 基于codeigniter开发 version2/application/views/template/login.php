<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
        	<h3 class="text-center">
				登录表
			</h3>
			<form class="form-horizontal" role="form" action="logining" method="post">
				<div class="form-group">
					 <label for="inputEmail3" class="col-sm-2 control-label">账号</label>
					<div class="col-sm-10">
						<input class="form-control" id="username" name="username" type="username" value="<?php echo $username; ?>"/>
					</div>
				</div>
				<div class="form-group">
					 <label for="inputPassword3" class="col-sm-2 control-label">密码</label>
					<div class="col-sm-10">
						<input class="form-control" id="password" name="password" type="password"/>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<div class="checkbox">
							 <label><input type="checkbox" />记住账号</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						 <button type="submit" class="btn btn-default">登陆</button>
                         <a href="/home/signup">
                            <button type="button" class="btn btn-default">注册</button>
                         </a>
                    </div>
				</div>
			</form>
		</div>
	</div>
</div>