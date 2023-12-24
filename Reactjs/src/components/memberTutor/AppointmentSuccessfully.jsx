import { Link } from "react-router-dom";
import axios from "axios";
import { useEffect, useState } from "react";
function AppointmentSuccessfully(){
    const [getData , setData] = useState("")
    var authTutor = localStorage.getItem("authTutor")
    if(authTutor){
        authTutor=JSON.parse(authTutor);
        var id_tutor= authTutor.data.auth.id;
        console.log(id_tutor)
    }
    useEffect(()=>{
        axios.get(`http://localhost/projectnew/public/tutor/list/appoint/`+ id_tutor)
        .then(response=>{
          console.log(response)
        })
        .catch(function(error){
          console.log(error)
        })
    },[])
    return(

        <div id="AppointmentSuccessfully">
            <div className="container">
                <div className="row">
                    <div className="col-sm-3 background-container mb-5">
                        <Link to="/memberTutor/AppointmentSuccessfully"><p className="red">Appointment successfully</p></Link>
                        <Link to="/memberTutor/AppointmentRefused"><p>Appointment is refused</p></Link>
                        <Link to="/memberTutor/ViewSavePostForTutor" ><p>Post Saved </p></Link>
                        <a data-bs-toggle="collapse" className="mb-3 arrow-link" data-bs-target="#demo"><p className="no-b-bt">Personal information <i className="fa-solid fa-chevron-down arrow-icon" /></p></a>
                        <div id="demo" className="collapse">
                        <ul>
                            <li><Link to="/memberTutor/UpdateTutor" className="fs-14">Edit personal information</Link></li>
                            <li><Link to="/memberTutor/ChangePasswordTutor" className="fs-14">Change Password</Link></li>
                        </ul>
                        </div>
                    </div>
                    <div className="col-sm-9">

                    </div>
                </div>
            </div>
        </div>
    )
}
export default AppointmentSuccessfully;