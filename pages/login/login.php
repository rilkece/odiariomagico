<!-- login/login.php -->
<?php 

?>
<main>
<div class="container h-100 border-top-0">
  <div class="row ">
      <div class="col-lg-6 col-md-12 align-middle h-100 p-5">      
          <div class="card border-success z-depth-2">  
              <div class="card-header text-center bg-success">
                  <strong class="text-white h5">Professor</strong>
              </div>
              <div class="card-body">
                  <div id="msg-teacher-created" class="bg-success white-text d-none">
                    <small>Professor criado com sucesso.</small>                    
                  </div>   
                  <div id="msg-error-auth-teacher" class="bg-danger white-text d-none">
                    <small>Email/senha incorretos.</small>                    
                  </div>   
                  <div id="msg-error-not-registered-teacher" class="bg-danger white-text d-none">
                    <small>Email não enviado.</small>                    
                  </div>   
                  <div id="msg-error-forgot-teacher" class="bg-danger white-text d-none">
                    <small>Preencha o email.</small>                    
                  </div>   
                  <div id="msg-error-sent-teacher" class="bg-info white-text d-none">
                    <small>Sua senha foi enviada para o email.</small>                    
                  </div>   
                  <div id="msg-logged-in" class="bg-success white-text d-none">
                    <small>Usuário logado.</small>                    
                  </div>   
                  <form id="formLoginTeacher" class="form-row">
                      <div class="col-12">
                          <label for="validationTeacherEmail">Email:</label>
                          <input type="email" class="form-control  mb-3" id="validationTeacherEmail" name="email" placeholder="Digite seu email" data-toggle="popover" title="Email vazio" data-content="Aqui vai algum tipo de conteúdo. Muito da hora, né?!" required>                          
                      </div>
                      <div class="col-12">
                          <label for="validationPassword">Senha:</label>
                          <input type="password" class="form-control  mb-3" id="validationTeacherPassword" name="senha" placeholder="Digite a senha" required>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input id="check_remember" type="checkbox" class="form-check-input" name="login_remember" value="checkedValue">
                              Lembrar usuário
                            </label>
                          </div>
                          <div class="text-right">
                          <a id="forgotSenha" class="text-success text-right w-100" ><i>Esqueci a senha</i></a> 
                          </div>                       
                      </div>
                      <button id="login_teacher" class="btn btn-success" type="submit">Entrar</button>                    
                  </form>   
                  <div id="progress_login_teacher" class="progress d-none">
                    <div  class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                  </div>                  
              </div>  
              <div class="card-footer text-right bg-success">
                  <a data-toggle="modal" data-target="#modalCreateTeacher" class="text-white h6"><i>Criar Conta</i></a>
              </div>
          </div>
      </div>
      <div class="col-lg-6 col-md-12 align-middle h-100 p-5">
          <div class="card  z-depth-2">  
              <div class="card-header text-center deep-orange darken-1">
                  <strong class="text-white h5">Estudante</strong>
              </div>
              <div class="card-body"> 
                <div id="msg-error-auth-student" class="bg-danger white-text d-none">
                  <small>Matrícula/senha incorretos.</small>                    
                </div>   
                  <form id="formLoginStudent" class="form-row">
                      <div class="col-12">
                          <label for="validationteacherMat">Matrícula:</label>
                          <input type="text" class="form-control  mb-3" id="validationStudentMat" name="matricula" placeholder="Digite sua matrícula" required>
                          
                      </div>
                      <div class="col-12">
                          <label for="validationSenha">Senha:</label>
                          <input type="password" class="form-control  mb-3" id="validationStudentPassword" name="senhaAluno" placeholder="Digite a senha" required>
                        
                      </div>
                      <button id="login_student" class="btn btn-deep-orange" type="submit">Entrar</button>
                  </form>   
                  <div id="progress_login_student" class="progress d-none">
                    <div  class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                  </div>                   
              </div> 
          </div>
      </div>
  </div>
</div>
</main>
<!-- END/ login/login.php -->


  