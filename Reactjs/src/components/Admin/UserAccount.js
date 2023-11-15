import { Link, useNavigate, useParams } from "react-router-dom";
import { useState,useEffect } from "react";
import axios from "axios";
function UserAccount(){
  const [getData , setData] = useState("")
    useEffect(()=>{
        axios.get(`http://localhost/projectnew/public/api/admin/list/tutor`)
        .then(response=>{
          console.log(response)
          setData(response.data.tutor)
        })
        .catch(function(error){
          console.log(error)
        })
      },[])
    function fetchData(){     
            if(Object.keys(getData).length>0){
                return getData.map((value)=>{
                    return(
                      <div className="col-sm-11 row UserAccount-background mt-3">
                      <div className="padding row">
                        <div className="col-sm-2">
                          <div className="img-container">
                            <img src={"http://localhost/projectnew/public/upload/"+value.avatar} alt={8888} />
                          </div>
                        </div>
                        <div className="col-sm-6">
                          <div className="UserAccount-name">
                            <h4 className="mb-1">{value.name}</h4>
                          </div>
                          <div className="UserAccount-detail">
                            <div className="UserAccount-email">
                              <p className="mb-0">Email: {value.email}</p>
                            </div>
                            <div className="UserAccount-phone">
                              <p className="mb-0">Phone: {value.phone}</p>
                            </div>
                            <div className="UserAccount-city">
                              <p className="mb-0">Province/City: {value.country}</p>
                            </div>
                            <div className="UserAccount-district">
                              <p className="mb-0">District : {value.district}</p>
                            </div>
                            <div className="UserAccount-job mb-3">
                              <p className="mb-0">You currently are... : {value.role}</p>
                            </div>
                          </div>
                        </div>
                        <div className="col-sm-4">
                          <div>
                            <Link className="btn btn-success" to={"/Admin/Dashboard/ViewDetailProfileTutor/"+ value.id}>View Details</Link>
                          </div>
                          <div>
                            <button className="btn btn-success" onClick={()=> acceptTutor(value.id)}>Approval</button>
                          </div>
                          <div>
                            <button className="btn btn-success">Reject</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    )
                })
            }
    }
    function acceptTutor(id) {
        axios.get(`http://localhost/projectnew/public/api/admin/accept/tutor/`+id)
          .then(response => {
            if(response.data.error){
              console.log(response.data.error)
            }else{
              setData(response.data.tutor)
            }
          })
          .catch(error => {
            console.error(error);
            // Xử lý lỗi nếu có
          });
    }
    return(
      <div id="UserAccount">
        <div className="container mb-4">
          <div className="row">
            <div className="col-sm-3 background-container mb-5">
              <Link className="fs-15" to="/Admin/Dashboard/Post"><p>Post Management</p></Link>
              <a data-bs-toggle="collapse" className="mb-3 arrow-link mt-1" data-bs-target="#demo"><p className="no-b-bt">User Management <i className="fa-solid fa-chevron-down arrow-icon" /></p></a>
              <div id="demo" className="collapse show">
                <ul>
                  <li><Link className="fs-14 red" to="/Admin/Dashboard/UserAccount">User Account</Link></li>
                  <li><Link className="fs-14" to="/Admin/Dashboard/UserStatictis">Account Statistíc</Link></li>
                </ul>
              </div>
            </div>
            <div className="col-sm-9">
              <div className="UserAccount-title">
                <p className="mbt-0">User Account</p>
              </div>
              <div className="border-bt" />
              {fetchData()}
            </div>
          </div>
        </div>
      </div>
    )
}
export default UserAccount;