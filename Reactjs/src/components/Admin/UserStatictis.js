import { Link, useNavigate, useParams } from "react-router-dom";
import { useState,useEffect } from "react";
import axios from "axios";
function UserStatictis(){
    return(
        <div id="UserStatictis">
            <div className="container mb-4">
                <div className="row">
                    <div className="col-sm-3 background-container mb-5">
                        <Link className="fs-15" to="/Admin/Dashboard/Post"><p>Post Management</p></Link>
                        <a data-bs-toggle="collapse" className="mb-3 arrow-link mt-1" data-bs-target="#demo"><p className="no-b-bt">User Management <i className="fa-solid fa-chevron-down arrow-icon" /></p></a>
                        <div id="demo" className="collapse show">
                        <ul>
                            <li><Link className="fs-14" to="/Admin/Dashboard/UserAccount">User Account</Link></li>
                            <li><Link className="fs-14 red" to="/Admin/Dashboard/UserStatictis">Account Statistíc</Link></li>
                        </ul>
                        </div>
                    </div>
                    <div className="col-sm-9">
                        <div className="UserStatictis-title">
                        <p className="mbt-0">User Statictis</p>
                        </div>
                        <div className="border-bt mb-4" />
                        <div className="col-sm-12 table-container">
                        <div className="btn-background mb-4">
                            <button className="btn btn-parents">Parents</button>
                            <button className="btn btn-tutor">Tutor</button>
                        </div>
                        <div className="table-responsive">
                            <table className="table table-bordered">
                            <thead className>
                                <tr className="table-secondary">
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr className>
                                <td scope="row">1</td>
                                <td>Nguyễn Văn D</td>
                                <td>TrươngThànhT@gmail.com</td>
                                </tr>
                                <tr className>
                                <td scope="row">2</td>
                                <td>Trần Đình T</td>
                                <td>TrầnĐìnhA@gmail.com</td>
                                </tr>
                                <tr className>
                                <td scope="row">3</td>
                                <td>Trần Đình A</td>
                                <td>VũTrọngQ@gmail.com</td>
                                </tr>
                                <tr className>
                                <td scope="row">4</td>
                                <td>Trương Thành T</td>
                                <td>MinhĐứcB@gmail.com</td>
                                </tr>
                                <tr className>
                                <td scope="row">5</td>
                                <td>Minh Đức B</td>
                                <td>NguyễnVănD@gmail.com</td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}
export default UserStatictis;