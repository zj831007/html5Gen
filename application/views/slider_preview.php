<!--slider style-->
<style>
	.coda-slider-wrapper {
		position:absolute;
		width:200px; 
		/*height: 276px;
		padding-left:30px;
		padding-right:30px;*/
		border: 1px solid red; 
		/*background-color:#ccc;*/
	}		
	.coda-slider, .coda-slider .panel {  width: 200px;} 
	.coda-slider-wrapper.arrows .coda-slider, .coda-slider-wrapper.arrows .coda-slider .panel { width: 200px; }
	.coda-nav-left { left: 0; top:50%;}
	.coda-nav-right { right: 0px; top:50%;}
	.coda-nav-left a{ 
		background:none no-repeat scroll 0 0 ; 
	}
	.coda-nav-right a{ 
		background:none no-repeat scroll 0 0 ; 
	}

	.coda-nav ul li a {
		height: 15px;
		padding: 2px;
		width: 15px;
		background-color: red;
		/*border: 1px solid red;*/
		-moz-border-radius: 17px;
		-khtml-border-radius: 17px;
		-webkit-border-radius: 17px;
		border-radius: 17px;

		-moz-box-shadow: 0 1px 3px rgba(0,0,0,0.5); 
		-webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.5); 
		text-shadow: 0 -1px 1px rgba(0,0,0,0.25); 
		border-bottom: 1px solid rgba(0,0,0,0.25); 

	}
	.coda-nav ul li a.current {
		 background: #f0a017;
		 color: #fff;
		/*background: url(images/slider-nav-over.png) no-repeat center center  transparent;*/
	}
	.coda-slider .panel-wrapper {height: 50px;  }
	
	.coda-nav li a:link, .coda-nav li a:visited {
		 background: #1e5a47;
		 color: #fff;
		/*background: url(images/slider-nav-out.png) no-repeat center center  transparent;*/
	}

	.coda-nav li a:over {
		background: #f0a017;
		 color: #fff;
		/*background: url(images/slider-nav-over.png) no-repeat center center  transparent;*/
	}
	h2.title{display:none;}

	.normal {
		height: 15px;			
		width: 15px;
		padding: 2px !important;
	}
	.small {
		height: 13px;
		width: 13px;
		padding: 0px !important;
		font-size: 11px;
	}
	.large {
		height: 17px;			
		width: 17px;
		padding: 4px !important;
	}

	.the_right{
		-moz-transform: rotate(180deg);
		-webkit-transform: rotate(180deg);
		-o-transform: rotate(180deg) ;
		-ms-transform: rotate(180deg);
		transform: rotate(180deg);
	}

</style>
<div class="coda-slider-wrapper" id="coda-slider-wrapper-1" style="visibility:hidden;">
	<div id="coda-nav-1" class="coda-nav" style="display:none;">
		<ul>
			<li class="tab1"><a href="#1" class="current large">1</a></li>
			<li class="tab2"><a href="#2" class="large">2</a></li>
			<li class="tab2"><a href="#3" class="large">3</a></li>
		</ul>
	</div>
	<div class="coda-nav-left" id="coda-nav-left-1" style="display:none">
		<a href="#"><img width="30" height="30" src="<?php echo base_url();?>css/slider/images/arrow_left.png"></a>
	</div>
	<div id="coda-slider-1" class="coda-slider" style="height: 50px;">
		<div class="panel-container" style="width: 2472px; margin-left: 0px;">
			<div class="panel" style="display: block;">
				<div class="panel-wrapper">
					<h2 class="title">1</h2>
					<img id="firstSliderImg-1"/>				
				</div>
			</div>		
	    </div>						
	    <div style="position: absolute; left: 0px; top: 0px; width: 100%; height: 246px; cursor: auto;" id="coda-slider-mask-1"></div>
	</div>
	<div class="coda-nav-right the_right" id="coda-nav-right-1" style="display:none;">
		<a href="#"><img width="30" height="30" src="<?php echo base_url();?>css/slider/images/arrow_left.png"></a>
	</div>
</div>	
