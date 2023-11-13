import { Link } from "react-router-dom";
function UserAccount(){
    return(
      <div id="UserAccount">
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
        <div className="UserAccount-title">
          <p className="mbt-0">User Account</p>
        </div>
        <div className="border-bt" />
        <div className="col-sm-11 row UserAccount-background mt-3">
          <div className="padding row">
            <div className="col-sm-2">
              <div className="img-container">
                <img src={"http://localhost/projectnew/public/image/Image17.png"} alt={8888} />
              </div>
            </div>
            <div className="col-sm-6">
              <div className="UserAccount-name">
                <h4 className="mb-1">Truong Thanh Dat</h4>
              </div>
              <div className="UserAccount-detail">
                <div className="UserAccount-email">
                  <p className="mb-0">Email: imneyu@gmail.com</p>
                </div>
                <div className="UserAccount-phone">
                  <p className="mb-0">Phone: 0948570558</p>
                </div>
                <div className="UserAccount-city">
                  <p className="mb-0">Province/City: Da Nang</p>
                </div>
                <div className="UserAccount-district">
                  <p className="mb-0">District : Thanh Khe</p>
                </div>
                <div className="UserAccount-job mb-3">
                  <p className="mb-0">You currently are... : University Lecturer</p>
                </div>
              </div>
            </div>
            <div className="col-sm-4">
              <div>
                <button className="btn btn-success">View Details</button>
              </div>
              <div>
                <button className="btn btn-success">Approval</button>
              </div>
              <div>
                <button className="btn btn-success">Reject</button>
              </div>
            </div>
          </div>
        </div>
          </div>
        </div>
      </div>
      </div>
    )
}
export default UserAccount;