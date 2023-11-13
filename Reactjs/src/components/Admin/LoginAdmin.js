function LoginAdmin(){
    return(
        <div id="login">
        <div className="container">
          <div className="row justify-content-center">
            <div className="col-sm-6">
              <div className="login-background">
                <div className="form-login">
                  <form className="row">
                    <div className="col-sm-12">
                      <div className="center mb-5">
                        <h3>Sign In Admin</h3>
                      </div>
                    </div>
                    <div className="col-sm-12">
                      <div className="center">
                        <div>
                          <h6 className="email">Email</h6>
                          <input type="text" required />
                        </div>
                        <div>
                          <h6 className="password">Password</h6>
                          <input type="password" required />
                        </div>
                      </div>
                    </div>
                    <div className="col-sm-12 mb-5">
                      <div className="center btn-login">
                        <button className="btn btn-success">Sign In</button>
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
export default LoginAdmin;