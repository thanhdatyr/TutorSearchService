import axios from "axios";
import { useEffect, useState } from "react";
import { Link } from "react-router-dom";
function ViewSavePostForTutor(){
    const [getData , setData] = useState("")
    const [isModalVisible2, setModalVisible2] = useState(false);
    const [isModalVisible3, setModalVisible3] = useState(false);
    const [selectedPost, setSelectedPost] = useState(null);
    var authTutor = localStorage.getItem("authTutor")
    if(authTutor){
      authTutor=JSON.parse(authTutor);
      var id_tutor= authTutor.data.auth.id;
    }
    useEffect(()=>{
        axios.get(`http://localhost/projectnew/public/api/tutor/get/wishlist/blog/${id_tutor}`)
        .then(response=>{
          setData(response.data.listblog)
          console.log(response.data.listblog)
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
                <div className="row ViewSavePostForTutor-content">
                  <div className="col-sm-2 mt-3">
                    <div className="ViewSavePostForTutor-content-avatar">
                      <img src={"http://localhost/projectnew/public/image/Image15.png"} alt="" />
                    </div>
                  </div>
                  <div className="col-sm-8 mt-3">
                    <div className="ViewSavePostForTutor-content-name">
                      <h5>{value.name}</h5>
                    </div>
                    <div className="ViewSavePostForTutor-content-detail">
                      <div className="Post-content-detail-title">
                        <p>{value.title}</p>
                      </div>
                      <div className="ViewSavePostForTutor-content-detail-class">
                        <p>Class: {value.class}</p>
                      </div>
                      <div className="ViewSavePostForTutor-content-detail-subject">
                        <p>Subject: {value.subject}</p>
                      </div>
                      <div className="ViewSavePostForTutor-content-detail-price">
                        <p>Cost/Hours <span>{value.price}k</span></p>
                      </div>
                      <div className="ViewSavePostForTutor-content-detail-address">
                        <p>Address: <span>{value.district},{value.country}</span></p>
                      </div>
                    </div>
                  </div>
                  <div className="col-sm-2 mt-3">
                    <div className="dropdown">
                      <a data-bs-toggle="dropdown">
                        <i className="fas fa-ellipsis-h" />
                      </a>
                      <ul className="dropdown-menu">
                        <li><a className="dropdown-item" href="#">Delete</a></li>
                      </ul>
                    </div>
                  </div>
                  <div className="col-sm-12 mb-3 ml30 mt-3">
                    <div className="ViewSavePostForTutor-content-detail-content">
                      <p className="w-90">{value.content}</p>
                    </div>
                  </div>
                  <div className="col-sm-12 mb-3">
                    <div className="ViewSavePostForTutor-btn-container-Apply ta-end">
                    <button onClick={() => handleApply(
                            value.id ,value.id_member
                        )} 
                        className="btn btn-success" >Apply</button>
                    </div>
                  </div>
                </div>
              </div>
                )
            })
        }
      }
      function handleApply(id,id_member){
        setSelectedPost({ id, id_member });
        // Hiển thị modal
        setModalVisible2(true); 
      }
      const[inputs,setInput]=useState({
        address:"",
        day:"",
        hour:"",
      })
      const handleInput = (e)=>{
        const nameInput = e.target.name;
        const value = e.target.value;
        console.log(value)
        setInput(state=>({...state,[nameInput]:value}))
      }
      function handleMakeAppointment(event) {
        event.preventDefault();
        if (selectedPost) {
          // Thực hiện gửi dữ liệu lên API
          Apply(selectedPost.id, selectedPost.id_member);
          // Đóng modal sau khi đã gửi dữ liệu
          setModalVisible2(false);
        }
      }
      function Apply(id_blog,id_member){
        console.log(id_member)
        const data={
          id_member:id_member,
          id_tutor:id_tutor,
          id_blog:id_blog,
          location:inputs.address,
          day:inputs.day,
          hour:inputs.hour
        } 
        console.log(data)
        axios.post("http://localhost/projectnew/public/api/tutor/makeappoint",data)
        .then(response=>{
          setModalVisible3(true);
        })
        .catch(error => {
          console.error(error);
          // Xử lý lỗi nếu cần thiết
        });
      }
      function renderModalAppointment(){
        return(
          <div>
          {/* Your existing code */}
          {isModalVisible2 && (
            <div className="modal modal-notification mb-4" id="myModal" style={{ display: isModalVisible2 ? 'block' : 'none' }}>
                <div id="appointment">
                  <div className="container">
                    <div className="row justify-content-center">
                      <div className="col-sm-8">
                        <form className="row form-appointment" onSubmit={handleMakeAppointment}>
                          <div className="form-title mb-3">
                            <p>Make a Appointment</p>
                          </div>
                          <div className="col-sm-4">
                            <div className="appointment-day">
                              <p className="font-weight fs-20">Day <span className="red">*</span></p>
                              <input type="date" name="day" id="txtDate" min="2000-01-01" required  onChange={handleInput}/>
                            </div>
                          </div>
                          <div className="col-sm-3">
                            <div className="appointment-hour">
                              <p className="font-weight fs-20">Hour <span className="red">*</span></p>
                              <input type="time" name="hour" id="txtTime" required onChange={handleInput}/>
                            </div>
                          </div>
                          <div className="col-sm-5 mb-5">
                            <div className="appointment-location">
                              <p className="font-weight fs-20">Location<span className="red">*</span></p>
                              <textarea rows="7" cols="33" placeholder="139 Nguyễn Hữu Thọ" name="address" required onChange={handleInput}/>
                            </div>
                          </div>
                          <div className="col-sm-12">
                            <div className="btn-container mb-4 center">
                              <button className="btn btn-success">Make an appointment</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          )}
        </div>
      )
      }
      function renderModalNotification(){
        return(
          <div>
          {/* Your existing code */}
          {isModalVisible3 && (
            <div className="modal modal-notification mb-4" id="myModal" style={{ display: isModalVisible3 ? 'block' : 'none' }}>
            <div className="modal-dialog">
              <div className="modal-content modal-createPost">
                {/* Modal Header */}
                <div className="modal-header mb-2">
                  <h4 className="modal-title">
                    Notification
                  </h4>
                </div>
                {/* Modal body */}
                <div className="modal-body mb-2">
                    Đặt lịch hẹn thành công 
                </div>
                {/* Modal footer */}
                <div className="modal-footer">
                <button
                    type="button"
                    className="btn btn-success"
                    data-bs-dismiss="modal"
                    onClick={() => {
                        setModalVisible3(false);
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
      )
      }
    return(
        <div id="ViewSavePostForTutor">
        <div className="container">
          <div className="row">
            <div className="col-sm-3 background-container mb-5">
              <Link to="/memberTutor/ViewSavePostForTutor" className="red" ><p>Post Saved </p></Link>
              <a data-bs-toggle="collapse" className="mb-3 arrow-link" data-bs-target="#demo"><p className="no-b-bt">Personal information <i className="fa-solid fa-chevron-down arrow-icon" /></p></a>
              <div id="demo" className="collapse">
                <ul>
                  <li><Link to="/memberTutor/UpdateTutor" className="fs-14">Edit personal information</Link></li>
                  <li><Link to="/memberTutor/ChangePasswordTutor" className="fs-14">Change Password</Link></li>
                </ul>
              </div>
            </div>
            <div className="col-sm-9">
              <div className="ViewSavePostForTutor-title">
                <p className="mbt-0">Post Saved</p>
              </div>
              <div className="border-bt" />
              {fetchData()}
            </div>
          </div>
        </div>
        {renderModalAppointment()}
        {renderModalNotification()}
      </div>
    )
}
export default ViewSavePostForTutor;