import axios from "axios";
import { useEffect, useState } from "react";
import { Link, useNavigate } from "react-router-dom";
function ForgotPasswordMember(){
  const[inputs,setInputs]=useState({
      email:"",
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
      if(inputs.email==""){
          errorSubmit.newpass="Vui lòng nhập email";
          flag = false;
      }
      if(!flag){
          setErrors(errorSubmit);
      }else{
          const data={
              email:inputs.email,
              role:1,
          }
          console.log(data)
          axios.post("http://localhost/projectnew/public/api/forgot/password",data)
          .then(response=>{
              console.log(response)
          })
      }
  }
  
    return(
        <div id="forgot-password">
          <div className="container">
            <div className="row justify-content-center">
              <div className="col-sm-6">
                <div className="login-background">
                  <div className="form-forgot-password">
                    <form className="row" onSubmit={handleSubmit}>
                      <div className="col-sm-12">
                        <div className="center">
                          <h3>Forgot Password Member</h3>
                          <h6>Enter your email for the verification process</h6>
                        </div>
                      </div>
                      <div className="col-sm-12">
                        <div className="center">
                          <div>
                            <h6 className="email">Email</h6>
                            <input type="text" required placeholder="Email account....." name="email" onChange={handleInput}/>
                          </div>
                        </div>
                      </div>
                      <div className="col-sm-12">
                        <div className="center btn-forgot-password">
                          <button className="btn btn-success">Forgot Password</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    )
}
export default ForgotPasswordMember;