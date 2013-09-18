$ ->
  $('.tab').last().hide()
  
  #event listeners
  $('.tab-titles a').on('click', (e) ->
    $('.tab').hide()
    e.preventDefault()
    id = $(e.currentTarget).attr('href')
    $(id).show()
  )



