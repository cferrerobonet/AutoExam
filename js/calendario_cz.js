document.observe('dom:loaded', function(){
	new PosCalendario();
});


var PosCalendario = Class.create({
	options: {
		selectorCalendario: 'div.fc_main',
		idLinkCalendario: 'iconoCalendario'
	},
	
	initialize: function(options){
		this.options = Object.extend(this.options, options);
		
		var _this = this;
		if($(this.options.idLinkCalendario)){
			this.conmutador = $(this.options.idLinkCalendario);
			this.conmutador.observe('click', function(ev){
				//console.log(this.cumulativeOffset()[1]);
				_this.posicionaCalendario(this.cumulativeOffset()[1], this.cumulativeOffset()[0], $$(_this.options.selectorCalendario)[0]);
			});
		}

	},
	
	posicionaCalendario: function(posicionTop, posicionLeft, capa){
		var posicionRespectoViewport = posicionTop - document.viewport.getScrollOffsets()[1] + capa.offsetHeight;
		if(posicionRespectoViewport > document.viewport.getDimensions().height){
			posicionTop = document.viewport.getDimensions().height + document.viewport.getScrollOffsets()[1] - capa.offsetHeight;
		}
		
		//return posicionTop;
		capa.setStyle({
			top: posicionTop + 'px',
			left: posicionLeft + 50 + 'px'
		});
	}
});