import axios from "axios";
import { useEffect, useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import Error from "../Error";
function ChangePassword(){
    const navigate = useNavigate();
    const[inputs,setInputs]=useState({
        newpass:"",
        confirmpassword:"",
    })
    const [isModalVisible, setModalVisible] = useState(false);
    const[errors,setErrors]=useState({})
    const handleInput = (e)=>{
      const nameInput = e.target.name;
      const value = e.target.value;
      setInputs(state=>({...state,[nameInput]:value}))
    }
    let authParents=localStorage.getItem("authParents");
    if(authParents){
        authParents = JSON.parse(authParents);
    }
    function handleSubmit(e){
        e.preventDefault();
        let errorSubmit = {};
        let flag=true;
        if(inputs.newpass==""){
            errorSubmit.newpass="Vui lòng nhập pass";
            flag = false;
        }else if(inputs.newpass.length <8){
            errorSubmit.newpass ="Vui lòng nhập mật khẩu >8 ký tự";
            flag= false;
        }
        if(inputs.confirmpassword==""){
          errorSubmit.confirmpassword="Vui lòng nhập confirmPassword";
          flag =false;
        }else if(inputs.confirmpassword != inputs.newpass){
          errorSubmit.connfirmpassword ="Mật khẩu của confirmPassword không giống với password";
          flag=false;
        }
        if(!flag){
            setErrors(errorSubmit);
        }else{
            const data={
                id:authParents.data.auth.id,
                name:authParents.data.auth.name,
                email:authParents.data.auth.email,
                password:inputs.newpass,
                phone:authParents.data.auth.phone,
                address:authParents.data.auth.address,
                id_country:authParents.data.auth.id_country,
                id_district:authParents.data.auth.id_district,
            }
            console.log(data)
            axios.post("http://localhost/projectnew/public/api/member/update",data)
            .then(response=>{
                console.log(response)
                    // Cập nhật trạng thái trong ReactJS
                var authUpdateParents={}
                authUpdateParents.data={}
                    // auth.user.auth_token=response.data
                authUpdateParents.data.auth=response.data.member
                localStorage.setItem("authParents",JSON.stringify(authUpdateParents))
                setModalVisible(true);
            })
        }
    }
    function renderModal(){
        return (
            <div>
              {/* Your existing code */}
              {isModalVisible && (
                <div className="modal modal-notification" id="myModal" style={{ display: isModalVisible ? 'block' : 'none' }}>
                <div className="modal-dialog">
                  <div className="modal-content">
                    {/* Modal Header */}
                    <div className="modal-header mb-2">
                      <h4 className="modal-title">
                        Notification
                      </h4>
                    </div>
                    {/* Modal body */}
                    <div className="modal-body mb-2">
                        Bạn Đã Đổi Mật Khẩu Thành Công.Xin Vui Lòng Đăng Nhập Lại
                    </div>
                    {/* Modal footer */}
                    <div className="modal-footer">
                    <button
                        type="button"
                        className="btn btn-success"
                        data-bs-dismiss="modal"
                        onClick={() => {
                            navigate('/memberParents/LoginParents');
                            localStorage.clear();
                        }}
                        >
                        Đóng
                    </button>
                    </div>
                  </div>
                </div>
              </div>
              )}
            </div>
        );
    }
    return(
        <div id="changePassword">
            <div className="container">
            <div className="row">
                <div className="col-sm-3 background-container mb-5">
                    <Link to="/memberParents/PostHistory" ><p>Post History </p></Link>
                    <Link to="/memberParents/ViewSaveTutor" href ><p>Tutor Saved </p></Link>
                    <a data-bs-toggle="collapse" className="mb-3 arrow-link" data-bs-target="#demo"><p className="no-b-bt">Personal information <i className="fa-solid fa-chevron-down arrow-icon" /></p></a>
                    <div id="demo" className="collapse show">
                    <ul>
                        <li><Link className="fs-14" to="/memberParents/UpdateMember">Edit personal information</Link></li>
                        <li><Link className="fs-14 red" to="/memberParents/ChangePassword">Change Password</Link></li>
                    </ul>
                </div>
                </div>
                <div className="col-sm-9">
                    <div className="changePassword-title">
                        <p>Change the password</p>
                    </div>  
                    <p className="border-bt" />
                <form onSubmit={handleSubmit} className="form-changePassword">
                    <div>
                        <p>Enter your new password <span className="red">*</span></p>
                        <input type="password" required name="newpass" onChange={handleInput}/>
                    </div>
                    <div>
                        <p>Confirm a new password <span>*</span></p>
                        <input type="password" required name="confirmpassword" onChange={handleInput}/>
                    </div>
                    <div className="center btn-change">
                        <button className="btn btn-success">Change</button>
                    </div>
                    <Error errors={errors}/>
                </form>
                </div>
            </div>
            </div>
            {renderModal()}
        </div>
    )
}
export default ChangePassword;