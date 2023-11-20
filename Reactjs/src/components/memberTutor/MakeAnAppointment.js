function MakeAnAppointment(){
    return(
        <div id="appointment">
        <div className="container">
          <div className="row justify-content-center">
            <div className="col-sm-8">
              <form className="row form-appointment">
                <div className="form-title mb-3">
                  <p>Make a Appointment</p>
                </div>
                <div className="col-sm-4">
                  <div className="appointment-day">
                    <p className="font-weight fs-20">Day <span className="red">*</span></p>
                    <input type="date" name="txtDate" id="txtDate" min="2000-01-01" />
                  </div>
                </div>
                <div className="col-sm-3">
                  <div className="appointment-hour">
                    <p className="font-weight fs-20">Hour <span className="red">*</span></p>
                    <input type="time" name="txtTime" id="txtTime" />
                  </div>
                </div>
                <div className="col-sm-5 mb-5">
                  <div className="appointment-location">
                    <p className="font-weight fs-20">Location<span className="red">*</span></p>
                    <input type="text" placeholder="139 Nguyễn Hữu Thọ" />
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
    )
}
export default MakeAnAppointment;