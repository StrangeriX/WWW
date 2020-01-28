const inputs = document.querySelectorAll('.controls input');
function handleUpdate() {
  const suffix = this.dataset.sizing || '';
  document.documentElement.style.setProperty(`--${this.name}`, this.value + suffix);
}

inputs.forEach(input => input.addEventListener('change', handleUpdate));
var s, Canvas = {
	settings: {
		height: 1000,
		width: 1000,
		blur: 0
	},
	canvas: document.getElementById('imageCanvas'),
	context: null,
	canvasContainer: document.querySelector('.canvasContainer'),
	imageLoader: document.getElementById('imageLoader'),
	originalCanvas: document.getElementById('originalCanvas'),
	originalContext: null,
	state: {
		isColorApplied: false
	},
	
	init: function() {
		s = this.settings;
		this.context = this.canvas.getContext('2d');
		this.originalContext = this.originalCanvas.getContext("2d");
		this.bindUIActions();
	},
	
	bindUIActions: function() {
		this.imageLoader.addEventListener('change', this.imageUpload, false);
	},
	
	
	imageUpload: function( e ) {
		var reader = new FileReader();
		reader.onload = function( event ) {
			var img = new Image();
			img.onload = function() {
				img = Canvas.scaleImageToBoundingBox(img);
				Canvas.context.drawImage( img, 0, 0, img.width, img.height);
				Canvas.originalContext.drawImage( img, 0, 0, img.width, img.height);
				Canvas.state.isColorApplied = false;
			}
			img.src = event.target.result;
		}
		reader.readAsDataURL( e.target.files[0] );
	},
	
	scaleImageToBoundingBox: function(img) {
		var scale = img.width / img.height;
		if (scale > 1) {
			img.width = s.width;
			img.height = img.width / scale;
		} else {
			img.height = s.height;
			img.width = img.height * scale;
		}
		
		Canvas.canvas.width = img.width;
		Canvas.canvas.height = img.height;
		Canvas.originalCanvas.width = img.width;
		Canvas.originalCanvas.height = img.height;
		Canvas.canvasContainer.style.width = img.width + "px";
		Canvas.canvasContainer.style.height = img.height + "px";
				
		return img;
	},
	
	resetImage: function() {
		var originalData = this.originalContext.getImageData(0, 0, s.width, s.height);
		this.context.putImageData(originalData, 0, 0);
		this.state.isColorApplied = false;
	},

	getOriginalColors: function() {
		var colors = [];
		var originalData = this.originalContext.getImageData(0, 0, s.width, s.height);
		var originalPixels = originalData.data;

		for (var i = 0, n = originalPixels.length; i < n; i += 4) {
			colors.push(new Color(
				originalPixels[i],
				originalPixels[i+1],
				originalPixels[i+2]
			));
		}

		return colors;

	},
	
	applyColor: function(color) {
		if (!Color.validateHexColor(color)) {
			alert(color + ' is not a valid hex color, please try again.');
			return;
		}
		
		var imageData = this.context.getImageData(0, 0, s.width, s.height);
		var pixels = imageData.data;

		if (color.length == 3) {
			color = Color.fullHexFromShort(color);
		}
		
		var red = parseInt(color.substring(1, 3), 16);
		var green = parseInt(color.substring(3, 5), 16);
		var blue = parseInt(color.substring(5, 7), 16);  
		
		
		if (!this.state.isColorApplied) {
			this.state.isColorApplied = true;
			
			for (var i = 0, n = pixels.length; i < n; i += 4) {
				pixels[ i ] = red;
				pixels[i+1] = green;
				pixels[i+2] = blue; 
			}
		} else {
			
			var originalData = this.originalContext.getImageData(0, 0, s.width, s.height);
			var originalPixels = originalData.data;
			
			var nextDistanceToOriginal = 0;
			var prevDistanceToOriginal = 0;
			for (var i = 0, n = pixels.length; i < n; i += 4) {
				prevDistanceToOriginal = Math.sqrt(
					Math.pow(pixels[i] - originalPixels[i], 2) +
					Math.pow(pixels[i+1] - originalPixels[i+1], 2) +
					Math.pow(pixels[i+2] - originalPixels[i+2], 2)
				);
				
				nextDistanceToOriginal = Math.sqrt(
					Math.pow(red - originalPixels[i], 2) +
					Math.pow(green - originalPixels[i+1], 2) +
					Math.pow(blue - originalPixels[i+2], 2)
				);
				if (nextDistanceToOriginal < prevDistanceToOriginal) {
					pixels[ i ] = red;
					pixels[i+1] = green;
					pixels[i+2] = blue;
				}
			}
		}
		this.context.putImageData(imageData, 0, 0);
	},
	
	applyColorArray: function(colors) {
		for (var i = 0; i < colors.length; i++) {
			this.applyColor(colors[i]);
		}
	}
}


Canvas.init();

var Controls = {
	resetButton: document.getElementById( 'reset' ),

	saveButton: document.getElementById( 'save' ),


	palettes: [],
	activePalette: null,
	
	init: function() {
		this.bindUIActions();

		this.activePalette = new Palette( document.getElementById( 'activePalette' ) );
		var paletteNodes = document.querySelectorAll( '.palette' );

		for (var i = 0; i < paletteNodes.length; i++){
			this.palettes.push(new Palette(paletteNodes[i]));
		}
	},
	
	bindUIActions: function() {
		this.resetButton.onclick = function() {
			Canvas.resetImage();
		};
		


		this.saveButton.addEventListener( 'click', function (e) {
			var dataURL = Canvas.canvas.toDataURL( 'image/png' );
			Controls.saveButton.href = dataURL;
		});
	},
}
Controls.init();




function Color(red, green, blue) {
	this.red = red;
	this.green = green;
	this.blue = blue;
}






Color.validateHexColor = function(color) {
	var isValidColorRegex = /(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i;
	return ( isValidColorRegex.test( color ) );
};

Color.fullHexFromShort = function(shortHex) {
	if (shortHex.length ===	 3) {
		return shortHex.substring(0, 1) + shortHex.substring(0, 1) +
			shortHex.substring(1, 2) + shortHex.substring(1, 2) +
			shortHex.substring(2, 3) + shortHex.substring(2, 3);	
	} 
};

function hexNormalizeNumber( number ) {
	if ( number < 0 ) { number = 0; } 
	if ( number > 255 ) { number = 255; }
	number = number.toString ( 16 ).toUpperCase();
	if ( number.length === 1 ) { number = "0" + number;	}

	return number;
}

function Palette(domElement) {
	var palette = {
		domElement: null,
		colors: [],
		
		bindUIActions: function() {
			this.domElement.addEventListener(
				'click',
				function( colors ) {
					var fn = function() {
						Canvas.applyColorArray( colors );
					};
					 
					return fn;
				}( this.colors )
			);
		},

		addColor: function(newColor) {
			if ( this.colors.indexOf( newColor ) === -1 ) {
				this.colors.push(newColor);
				this.showColors( this.colors );	
			}
		},

		showColors: function(colorArray) {

			while ( this.domElement.firstChild ) {
 			   this.domElement.removeChild( this.domElement.firstChild );
			}

			var numberOfColors = colorArray.length;
	
			for ( var i = 0; i < numberOfColors; i++ ) {
				var colorDiv = document.createElement( 'div' );
				colorDiv.classList.add( 'color' );
				this.domElement.appendChild( colorDiv );

				colorDiv.style.background = colorArray[ i ];
					
				parentTotalWidth = this.domElement.offsetWidth;
				parentBorderWidth = parseInt(
					getComputedStyle( this.domElement ).getPropertyValue( 'border-left-width' ),
					10
				);
				colorDiv.style.width = ( ( parentTotalWidth - parentBorderWidth * 2 ) / numberOfColors) + "px";
			}
		}
	};
	
	palette.domElement = domElement;
	palette.bindUIActions();
	
	// Pushes all colors on the array.
	var colorDivs = domElement.getElementsByTagName( 'div' );
	for (var i = 0; i < colorDivs.length; i++) {
		palette.colors.push(colorDivs[i].dataset.color);
	}
	palette.showColors( palette.colors );
	
	return palette;  
}


