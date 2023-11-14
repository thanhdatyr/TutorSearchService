import { Link, useNavigate, useParams } from "react-router-dom";
import { useState,useEffect } from "react";
import axios from "axios";
function Post(){
    var authParents = localStorage.getItem("authParents")
    if(authParents){
        authParents=JSON.parse(authParents);
        var idParents =authParents.data.auth.id
    }
    const [getData , setData] = useState("")
    useEffect(()=>{
        axios.get(`http://localhost/projectnew/public/api/admin/list/blog`)
        .then(response=>{
          console.log(response)
          setData(response.data.blog)
        })
        .catch(function(error){
          console.log(error)
        })
      },[])
    function fetchData(){     
            if(Object.keys(getData).length>0){
                return getData.map((value)=>{
                    console.log(value)
                    return(
                        <div className="col-sm-11 padding">
                            <div className="row postHistory-content">
                                <div className="col-sm-2 mt-3">
                                    <div className="postHistory-content-avatar">
                                        <img src={"http://localhost/projectnew/public/image/Image15.png"} alt="" />
                                    </div>
                                </div>
                                <div className="col-sm-8 mt-3">
                                        <div className="postHistory-content-name">
                                        <h5>{value.name}</h5>
                                        </div>
                                        <div className="postHistory-content-detail">
                                        <div className="Post-content-detail-title">
                                            <p>{value.title}</p>
                                        </div>
                                        <div className="postHistory-content-detail-subject">
                                            <p>Subject: {value.subject}</p>
                                        </div>
                                        <div className="postHistory-content-detail-form">
                                            <p>Class: <span>{value.class}</span></p>
                                        </div>
                                        <div className="postHistory-content-detail-price">
                                            <p>Tuition/ 1 student: <span>{value.price}k</span></p>
                                        </div>
                                        <div className="postHistory-content-detail-address">
                                            <p>Address: <span>{value.country}, {value.district}</span></p>
                                        </div>
                                        </div>
                                </div>
                                <div className="col-sm-12 mb-3 ml30 mt-3">
                                    <div className="postHistory-content-detail-content">
                                        <p className="w-90">{value.content}</p>
                                    </div>
                                </div>
                                <div className="col-sm-12 mb-3">
                                <div className="flex justify-content-end">
                                    <div className="btn-reject">
                                        <button className="btn btn-success">Reject</button>
                                    </div>
                                    <div className="btn-approval">
                                        <button className="btn btn-success">Approval</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    )
                })
            }
    }
    
    return(
        <div id="Post">
        <div className="container mb-4">
        <div className="row">
          <div className="col-sm-3 background-container mb-5">
            <a data-bs-toggle="collapse" className="mb-3 arrow-link" data-bs-target="#demo"><p className="no-b-bt">User Management <i className="fa-solid fa-chevron-down arrow-icon" /></p></a>
            <div id="demo" className="collapse show">
              <ul>
                <li><Link className="fs-14 red">User Account</Link></li>
                <li><Link className="fs-14">Account Statistíc</Link></li>
              </ul>
            </div>
          </div>
          <div className="col-sm-9">
                <div className="postHistory-title">
                    <p className="mbt-0">Post History</p>
                </div>
                <div className="border-bt" />
                {fetchData()}
          </div>
        </div>
      </div>
      </div>
    )
}
export default Post;