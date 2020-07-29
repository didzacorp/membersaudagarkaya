<style type="text/css">
.avatar-upload {
  position: relative;
  max-width: 205px;
  margin: 0px auto;
}
.avatar-upload .avatar-edit {
  position: absolute;
  right: 12px;
  z-index: 1;
  top: 10px;
}
.avatar-upload .avatar-edit input {
  display: none;
}
.avatar-upload .avatar-edit input + label {
  display: inline-block;
  width: 34px;
  height: 34px;
  margin-bottom: 0;
  border-radius: 100%;
  background: #FFFFFF;
  border: 1px solid transparent;
  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
  cursor: pointer;
  font-weight: normal;
  transition: all 0.2s ease-in-out;
}
.avatar-upload .avatar-edit input + label:hover {
  background: #f1f1f1;
  border-color: #d6d6d6;
}
.avatar-upload .avatar-edit input + label:after {
  content: "\f040";
  font-family: 'FontAwesome';
  color: #757575;
  position: absolute;
  top: 10px;
  left: 0;
  right: 0;
  text-align: center;
  margin: auto;
}
.avatar-upload .avatar-preview {
  width: 192px;
  height: 192px;
  position: relative;
  border-radius: 100%;
  border: 6px solid #F8F8F8;
  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
}
.avatar-upload .avatar-preview > div {
  width: 100%;
  height: 100%;
  border-radius: 100%;
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
}
</style>
<script type="text/javascript">
$(function () {
        hideProgres();
        // pageLoadFunnel(1);
        <?php 
          if (empty($profile['nomor_rekening'])) {
            ?>
            $('#NamaRekening').removeAttr('readonly');
            $('#namaBank').removeAttr('readonly');
            $('#NoRekBank').removeAttr('readonly');
            <?php
          }else{
            ?>
              $('#NamaRekening').attr({
                readonly: 'readonly'
              });
              $('#namaBank').attr({
                readonly: 'readonly'
              });
              $('#NoRekBank').attr({
                readonly: 'readonly'
              });
            <?php
          }
         ?>

         $('#submitProfile').submit(function(e){
          e.preventDefault(); 
          var formData = new FormData();
          formData.append('telpn', $('#NoTelpnMember').val());
          formData.append('alamat', $('#alamatMember').val());
          formData.append('file', document.getElementById("imageUpload").files[0]);
               $.ajax({
                   url:'<?php echo base_url();?>/profile.member/manage/saveProfile',
                   type:"post",
                   data:formData,
                   processData:false,
                   contentType:false,
                   cache:false,
                   async:false,
                    success: function(data){
                      if (data.error) {
                          showDangerToast(data.error);
                      }else{
                          showSuccessToast(data.message);
                          loadMainContentMember('/profile.member/manage');
                      }
                 }
               });
          });
  });

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload").change(function() {
    readURL(this);
});
  // function pageLoadFunnel(pg)
  // { 
  //   showProgres();
  //   $.post(base_url(1)+'/trafic.member/manage/page/'+pg
  //     ,$('#filter_content').serialize()
  //     ,function(result) {
  //       $('#resultContent').html(result);
  //       hideProgres();
  //     }         
  //     ,"html"
  //   );
  // }
    function saveProfile(){ 
      showProgres();
      $.post(base_url(1)+'/profile.member/manage/saveProfile'
        ,{
          telpn : $('#NoTelpnMember').val(),
          alamat : $('#alamatMember').val()
        }
        ,function(result) {
          if (result.error) {
              showDangerToast(result.error);
          }else{
              showSuccessToast(result.message);
              loadMainContentMember('/profile.member/manage');
          }
        }         
        ,"json"
      );
    } 
    function saveBank(){ 
      showProgres();
      $.post(base_url(1)+'/profile.member/manage/saveBank'
        ,{
          nama_rekening : $('#NamaRekening').val(),
          nama_bank       : $('#namaBank').val(),
          nomor_rekening : $('#NoRekBank').val()
        }
        ,function(result) {
          if (result.error) {
              showDangerToast(result.error);
          }else{
              showSuccessToast(result.message);
              loadMainContentMember('/profile.member/manage');
          }
        }         
        ,"json"
      );
    }

    function savePassword(){ 
      showProgres();
      $.post(base_url(1)+'/profile.member/manage/savePassword'
        ,{
          old_pass : $('#PasswordLama').val(),
          new_pass : $('#NewPassword').val(),
          kon_pass : $('#KonfirmasiPassword').val()
        }
        ,function(result) {
          if (result.error) {
              showDangerToast(result.error);
          }else{
              showSuccessToast(result.message);
              loadMainContentMember('/profile.member/manage');
          }
        }         
        ,"json"
      );
    } 
</script>
 <div class="content-wrapper">
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Profile</h4>
          <div class="tab-minimal tab-minimal tab-minimal-success">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="tab-4-1" data-toggle="tab" href="#home-4-1" role="tab" aria-controls="home-4-1" aria-selected="true"><i class="mdi mdi-home-outline"></i>Profile</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="tab-4-2" data-toggle="tab" href="#profile-4-2" role="tab" aria-controls="profile-4-2" aria-selected="false"><i class="mdi mdi-account-outline"></i>Password</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="tab-4-3" data-toggle="tab" href="#contact-4-3" role="tab" aria-controls="contact-4-3" aria-selected="false"><i class="mdi mdi-message-text-outline"></i>Rekening</a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="home-4-1" role="tabpanel" aria-labelledby="tab-4-1">
                <div class="row">
                  <div class="col-md-4">
                  </div>
                  <div class="col-md-4">
                      <form class="forms-sample" id="submitProfile" method="post">
                        <div class="form-group">
                          <div class="avatar-upload">
                              <div class="avatar-edit">
                                  <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                                  <label for="imageUpload"></label>
                              </div>
                              <div class="avatar-preview">
                                <?php if ($profile['foto']){ ?>
                                    <div id="imagePreview" 
                                        style="background-image: url(<?= base_url() ?>/assets/images/profile/<?= $profile['foto'] ?>);">
                                    </div>
                                <?php 
                                } else{
                                ?>
                                  <div id="imagePreview" 
                                        style="background-image: url(<?= base_url() ?>/assets/ui-member/images/logo/users.gif);">
                                  </div>
                                <?php
                                }
                                ?>
                                  
                                  
                              </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="exampleInputName1">Name</label>
                          <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" value="<?= $profile['nama'] ?>" readonly>
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail3">Email</label>
                          <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Email" value="<?= $profile['email'] ?>" readonly>
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail3">Nomor Telpn</label>
                          <input type="text" class="form-control" id="NoTelpnMember" placeholder="Nomor Telpn" value="<?= $profile['nomor_telepon'] ?>" >
                        </div>
                        <div class="form-group">
                          <label for="exampleInputCity1">Alamat</label>
                          <textarea class="form-control" id="alamatMember"><?= $profile['alamat'] ?></textarea>
                        </div>
                        <div class="form-group">
                          <hr>
                          <button class="btn btn-success">Ubah Profile</button>
                          <hr>
                        </div>
                      </form>
                  </div>
                  <div class="col-md-4"></div>
                </div>
              </div>
              <div class="tab-pane fade" id="profile-4-2" role="tabpanel" aria-labelledby="tab-4-2">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="col-md-4">
                      </div>
                      <div class="col-md-4">
                        <form class="forms-sample">
                          <div class="form-group">
                            <label for="exampleInputEmail3">Password Lama</label>
                            <input type="password" class="form-control" id="PasswordLama" name="PasswordLama">
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail3">Password Baru</label>
                            <input type="password" class="form-control" id="NewPassword" name="NewPassword" >
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail3">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="KonfirmasiPassword" name="KonfirmasiPassword">
                          </div>

                          <div class="form-group">
                            <hr>
                            <a href="javascript:void(0)" class="btn btn-success" onclick="savePassword();">Ubah Password</a>
                            <hr>
                          </div>
                        </form>
                      </div>
                      <div class="col-md-4">
                      </div>
                    </div>
                  </div>
              </div>
              <div class="tab-pane fade" id="contact-4-3" role="tabpanel" aria-labelledby="tab-4-3">
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                      <form class="forms-sample">
                        <div class="form-group">
                          <label for="exampleInputEmail3">Nama Rekening</label>
                          <input type="email" class="form-control" id="NamaRekening" placeholder="Nama Rekening" value="<?= $profile['nama_rekening'] ?>">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail3">Nama Bank</label>
                          <input type="email" class="form-control" id="namaBank" placeholder="Nama Bank" value="<?= $profile['nama_bank'] ?>">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail3">Nomor Rekening</label>
                          <input type="email" class="form-control" id="NoRekBank" placeholder="Nomor Rekening" value="<?= $profile['nomor_rekening'] ?>">
                        </div>
                        
                        <div class="form-group">
                          <hr>
                          <a href="javascript:void(0)" class="btn btn-primary" onclick="saveBank();">Ubah Rekening</a>
                          <hr>
                        </div>
                      </form>
                    </div>
                    <div class="col-md-4">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
