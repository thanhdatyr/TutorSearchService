import { Link, useLocation, useNavigate } from "react-router-dom";
import ForgotPassword from "../member/ForgotPassword";
import { useEffect,useState } from "react";
import axios from "axios";
import Error from "../Error";
function LoginAdmin(){
  const navigate = useNavigate();
  const[inputs,setInput]=useState({
      email:"",
      password:"",
    })
  const[errors,setErrors]=useState({})
  
  const handleInput = (e)=>{
    const nameInput = e.target.name;
    const value = e.target.value;
    setInput(state=>({...state,[nameInput]:value}))
  }
  function handleSubmit(e){
        e.preventDefault();
        let errorSubmit = {};
        let flag=true;
        if(inputs.email==""){
            errorSubmit.email = "Vui lòng nhập email";
            flag = false;
        }
        if(inputs.pass==""){
            errorSubmit.password="Vui lòng nhập pass";
            flag = false;
        }
        if(inputs.checkbox==""){
            errorSubmit.checkbox="Vui lòng chọn";
            flag = false;
        }
        if(!flag){
            setErrors(errorSubmit);
        }
        if(flag){
            const data={
                email:inputs.email,
                password:inputs.password
            }
            console.log(data)
            axios.post("http://localhost/projectnew/public/api/admin/login",data)
            .then(response=>{
                if(response.data.errors){
                    alert("Lỗi") 
                }else{
                    navigate('/Admin/Dashboard');
                }
            })
            .catch(function(error){
                console.log(error)
            })
        }
    }
    return(
        <div id="login">
        <div className="container">
          <div className="row justify-content-center">
            <div className="col-sm-6">
              <div className="login-background">
                <div className="form-login">
                  <form className="row" onSubmit={handleSubmit}>
                    <div className="col-sm-12">
                      <div className="center mb-5">
                        <h3>Sign In Admin</h3>
                      </div>
                    </div>
                    <div className="col-sm-12">
                      <div className="center">
                        <div>
                          <h6 className="email">Email</h6>
                          <input type="text" required name="email" onChange={handleInput}/>
                        </div>
                        <div>
                          <h6 className="password">Password</h6>
                          <input type="password" required name="password" onChange={handleInput} />
                        </div>
                      </div>
                    </div>
                    <div className="col-sm-12 mb-5">
                      <div className="center btn-login">
                        <button className="btn btn-success">Sign In</button>
                      </div>
                    </div>
                    <Error errors={errors}/>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    )
}
export default LoginAdmin;