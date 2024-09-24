import React, { useState } from "react";
import PatientForm from "./components/PatientForm";
import PatientList from "./components/PatientList";
// import Prediction from "./components/Prediction";

const App = () => {
  const [patients, setPatients] = useState([]);

  const handleFormSubmit = (data) => {
    setPatients([...patients, data]);
  };

  return (
    <div className="App">
      <h1>Electronic Patient File (EPF) System</h1>
      <PatientForm onSubmit={handleFormSubmit} />
      <PatientList patients={patients} />
      {patients.length > 0}
    </div>
  );
};

export default App;
