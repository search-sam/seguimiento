
# FORMACIÓN ACADÉMICA
$ document
    .on 'click', '#agregar-academico', ->
        $.get '/ajax/add_academico', (data) ->
            $ '#estudio-row'
                .append data
            $ '#agregar-academico'
                .replaceWith '<a class="agregar quitar"><i class="fa fa-minus"></i></a>'

$ document
    .on 'change', '.tipo-estudio', ->
        el = $ this
            .parents('.row').find('.estudio')
        opcion = $ this
            .val().localeCompare("5")
        if opcion == 0
            $.get '/ajax/add_estudio', (data) ->
                el.replaceWith data
        else
            el.replaceWith '<input type="text" name="estudio_academico[0]" placeholder="Estudio/Carrera" class="estudio">'

# QUITAR
$ document
    .on 'click', '.quitar', ->
        $ this
            .parents('.row').css 'display', 'none'

# EXPERIENCIA LABORAL
$ document
    .on 'click', '#agregar-laraboral', ->
        row = '<div class="row"><div class="col-md-4 col-sm-12"><div class="form-group"><input type="text" name="cargo_laboral[]" placeholder="Cargo"></div></div><div class="col-md-3 col-sm-12"><div class="form-group"><input type="text" name="institucion_laboral[]" placeholder="Instituci&oacute;n"></div></div><div class="col-md-2 col-sm-12"><div class="form-group"><input type="text" name="ciudad_empresa[]" placeholder="Ciudad"></div></div><div class="col-md-2 col-sm-12"><div class="form-group"><input type="text" name="periodo_laboral[]" placeholder="Per&iacute;odo"></div></div><div class="col-md-1 col-sm-12"><div class="form-group"><a class="agregar" id="agregar-laraboral"><i class="fa fa-plus"></i></a></div></div></div>'
        $ '#laboral-row'
            .append row
        $ this
            .replaceWith '<a class="agregar quitar"><i class="fa fa-minus"></i></a>'

# RECONOCIMIENTOS
$ document
    .on 'click', '#agregar-reconocimiento', ->
        row = '<div class="row"><div class="col-md-4 col-sm-12"><div class="form-group"><input type="text" name="merito_reconocimiento[]" placeholder="Merito"></div></div><div class="col-md-3 col-sm-12"><div class="form-group"><input type="text" name="organizacion_reconocimiento[]" placeholder="Organizaci&oacute;"></div></div><div class="col-md-2 col-sm-12"><div class="form-group"><input type="text" name="ciudad_reconocimiento[]" placeholder="Ciudad"></div></div><div class="col-md-2 col-sm-12"><div class="form-group"><input type="text" name="periodo_reconicimiento[]" placeholder="A&ntilde;o"></div></div><div class="col-md-1 col-sm-12"><div class="form-group"><a id="agregar-reconocimiento" class="agregar"><i class="fa fa-plus"></i></a></div></div></div>'
        $ '#reconocimiento-row'
            .append row
        $ this
            .replaceWith '<a class="agregar quitar"><i class="fa fa-minus"></i></a>'

# Alert dissmise animation
$ document
    .on 'click', '.closebtn', ->
         div = @parentElement
         div.style.opacity = '0'
         setTimeout (-> div.style.display = 'none' ), 600

# Seleccionar uno o varios estudiantes
$ document
    .on 'click', '.info-box-icon', ->
        estudiante_seleccionado = $ this
            .parents('.box-selectable')
        if estudiante_seleccionado.children('input:checkbox').is(':checked')
            estudiante_seleccionado.children('input:checkbox').prop('checked', false)
            estudiante_seleccionado.css({'background-color': 'white', 'color': '#808080'})
        else
            estudiante_seleccionado.children('input:checkbox').prop('checked', true)
            estudiante_seleccionado.css({'background-color': '#1C3170', 'color': 'white'})

$ document
    .on 'click', '#enviar', ->
        seleccionados = $ 'input:checked'
            .length
        if (seleccionados-1) <= 0
            alert 'No ha seleccionado al menos un estudiante'
        else
            $ '#asignar-form'
                    .submit()

# Tamaño de los cards de estudiantes
cards = $ document
    .find('.info-box')
cards.each ->
    alto = $ this
        .height()
    css = '{"height":"'+alto+'px", "width":"'+alto+'px"'
    if alto > 90
        css += ', "margin-right":"10px"}'
    else
        css += '}'

    $ this
        .children('.info-box-icon').css(JSON.parse(css))

    $ this
        .find('.img-circle').css({'max-height':(alto-10)+'px', 'max-width':(alto-10)+'px', 'overflow':'hidden'})

# Super Administrador selection
$ document
    .on 'click', '.control-sidebar-menu li', ->
        $ '.control-sidebar-menu li'
            .removeClass('selected')
        $ this
            .addClass('selected')
        id = $ this
            .attr('data')
        $.get '/ajax/add_flash/' + id, (data) ->
            console.log(data)
