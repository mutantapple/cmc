( function( $ ){

	$.fn.speedometer = function( options ){
	
		/* A tad bit speedier, plus avoids possible confusion with other $(this) references. */
		var $this = $( this );
		

		
		/* handle multiple selectors */
		if ( $this.length > 1 ) {
			$this.each( function(){
				$( this ).speedometer( options );
				
			});
			return $this;
		}	

		var def = {
			/* If not specified, look in selector's innerHTML before defaulting to zero. */
			percentage : $.trim( $this.html() ) || 0,
			scale: 100,
			limit: true,
			minimum: 0,
			maximum: 100,
			suffix: ' %',
			animate:true,
			thisCss: {
				position: 'relative', /* Very important to align needle with gague. */
				width: '210px',
				height: '180px',
				padding: '0px',
				border: '0px',
				fontFamily: 'Arial',
				fontWeight: '900',
				backgroundImage : "url('./background.jpg')"

		
			},
			digitalCss: {
				backgroundColor:'black',
				borderColor:'#555555 #999999 #999999 #555555',
				borderStyle:'solid',
				borderWidth:'2px',
				color:'white',
				fontSize:'16px',
				height:'20px',
				left:'72px',
				padding:'1px',
				position:'absolute',
				textAlign:'center',
				top:'65px',
				width:'60px',
				zIndex:'10',
				lineHeight:'20px',
				overflow:'hidden'
			}
		}
		

		
		$this.html( '' );
		
		$this.css( def.thisCss );
		
		$.extend( def, options );
		
		/* out of range */
		if ( def.limit && ( def.percentage > def.maximum || def.percentage < def.minimum ) ) {
			/* the glass cracks */
			$this.css( 'backgroundImage' , 'url("./background-broken.jpg")' );
		} else {
		
			




		
			/* call modified jqcanvas file to generate needle line */
			$this.jqcanvas ( function ( canvas, width, height ) {
		
				var ctx = canvas.getContext ( "2d" ),
				lingrad, thisWidth;
	
				ctx.lineWidth = 2;
				ctx.strokeStyle = "rgb(255,0,0)";
				
				/* point of origin for drawing AND canvas rotation (lines up with middle of the black circle on the image) */
				ctx.translate( 105,105 );	
							
				ctx.save(); //remember linewidth, strokestyle, and translate
				
				function animate(){		
		
					ctx.restore(); //reset ctx.rotate to properly draw clearRect
					ctx.save();	//remember this default state again
		
					ctx.clearRect( -105, -105, 300, 300 ); //erase the canvas
		
					
					
		
		
					/* rotate based on percentage. */
					ctx.rotate( i * Math.PI / def.scale );
		
		
		
					/* draw the needle */
					ctx.beginPath();
					ctx.moveTo( -80,0 );
					ctx.lineTo( 10,0 );
					ctx.stroke();
					
					/* internally remember current needle value */
					$this.data('currentPercentage',i);
					
					if ( i != def.percentage ) {
					
						//properly handle fractions
						i += Math.abs( def.percentage - i ) < 1 ? def.percentage - i : def.increment;
		
						setTimeout(function(){
							animate()
						},20);
					}
				}				
				
				/* Are we animating or just displaying the percentage? */
				if (def.animate) {
					var i = parseInt( $this.data('currentPercentage') ) || 0;
					def.increment = ( i < def.percentage ) ? 1 : -1;
				} else {
					var i = ( def.percentage );
				}
				
				
				animate();
				
				
				
			
			}, { verifySize: false, customClassName: '' } );


		
		}
		
		/* digital percentage displayed in middle of image */

		var digitalGauge = $( '<div></div>' );
		$this.append( digitalGauge );
		digitalGauge.css( def.digitalCss );
		digitalGauge.text( def.percentage + def.suffix );
		

		
		return $this;

	}

	

})( jQuery )