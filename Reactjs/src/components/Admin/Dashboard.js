import { Link } from "react-router-dom";
function Dashboard(){
    return(
       <div className="container mb-4">
        <div className="row">
          <div className="col-sm-3 background-container mb-5">
            <Link className="fs-15" to="/Admin/Dashboard/Post"><p>Post Management</p></Link>
            <a data-bs-toggle="collapse" className="mb-3 arrow-link mt-1" data-bs-target="#demo"><p className="no-b-bt">User Management <i className="fa-solid fa-chevron-down arrow-icon" /></p></a>
            <div id="demo" className="collapse">
              <ul>
                <li><Link className="fs-14" to="/Admin/Dashboard/UserAccount">User Account</Link></li>
                <li><Link className="fs-14">Account Statistíc</Link></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    )
}
export default Dashboard;