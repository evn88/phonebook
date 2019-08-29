
<!-- Modal бронирование -->
<div class="modal fade" id="booking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ $title_booking }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <form action="{{ route($route) }}" method="post" autocomplete="off">
          @csrf
          
          <div class="modal-body">
            <input type="hidden" name="{{ $id }}" value="0"> 
            <input type="hidden" name="ip" value="0" id="hidden_ip_buy">    
                  <div class="form-group">
                      <input type="text" name="username" class="form-control" placeholder="Введите ваше ФИО" autofocus required>
                  </div>
                  <div class="form-group">
                      <input type="text" name="area" class="form-control" placeholder="Введите ваш филиал или участок " required>
                  </div>
                  <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Ваш СЛУЖЕБНЫЙ электронный почтовый адрес " required>
                </div>
                    <p class="alert alert-danger">Указывайте обязательно свой служебный электронный адрес (тот что заканчивается на ...@voel.ru или ...@...voel.ru), на этот адрес будет отправлена ссылка для подтверждения ставки</p>
                    <p class="alert alert-info">После бронирования техники – <a href="<?php echo asset("storage/contract.doc")?>">заполните договор (воспользовавшись шаблоном)</a> 
                        и направьте подписанный в двух экземплярах документ в Отдел информационных технологий вашего филиала 
                        <br>
                        <br> 
                        <b>Если в течении 5-ти дней, после окончания аукциона, договор не будет предоставлен – бронь АННУЛИРУЕТСЯ.</b> 
                    </p>
                    <a href="<?php echo asset("storage/contract.doc")?>" class="btn btn-primary btn-block">Скачать бланк договора</a>
          </div>
  
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                  <button type="submit" class="btn btn-primary" >Забронировать</button>
              </div>
          </div>
      </form>
    </div>
</div>

<!-- Modal перекупить -->
<div class="modal fade" id="rebooking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ $title_rebooking }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <form action="#" method="post" autocomplete="off">
          @csrf
          <div class="modal-body">

            <input type="hidden" name="{{ $id }}" value="0">       
            <input type="hidden" name="ip" value="0" id="hidden_ip_rebuy">       
                  <div class="form-group">
                      <input type="text" name="username" class="form-control" placeholder="Введите ваше ФИО" autofocus required>
                  </div>
                  <div class="form-group">
                      <input type="text" name="area" class="form-control" placeholder="Введите ваш филиал или участок " required>
                  </div>
                  <div class="form-group">
                      <input type="email" name="email" class="form-control" placeholder="Ваш СЛУЖЕБНЫЙ электронный почтовый адрес " required>
                  </div>
                  <p class="alert alert-danger">Указывайте обязательно свой служебный электронный адрес (тот что заканчивается на ...@voel.ru или ...@...voel.ru), на этот адрес будет отправлена ссылка для подтверждения ставки</p>
                  <p class="alert alert-warning" role="alert"><b>ВНИМАНИЕ:</b> Перекупка техники добавит +500₽ к текущей стоимости!</p>
                    <p class="alert alert-info">После бронирования техники – <a href="<?php echo asset("storage/contract.doc")?>">заполните договор (воспользовавшись шаблоном)</a> 
                        и направьте подписанный в двух экземплярах документ в Отдел информационных технологий вашего филиала 
                        <br>
                        <br> 
                        <b>Если в течении 5-ти дней, после окончания аукциона, договор не будет предоставлен – бронь АННУЛИРУЕТСЯ.</b> 
                    </p>
                    <a href="<?php echo asset("storage/contract.doc")?>" class="btn btn-primary btn-block">Скачать бланк договора</a>
              </div>
              <div class="modal-footer">
                  {{-- <small id=list class="text-muted">-</small> --}}
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                  <button type="submit" class="btn btn-primary" >Перекупить</button>
              </div>
          </div>
      </form>
    </div>
  </div>