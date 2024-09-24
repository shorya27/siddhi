import React from "react";

const PatientList = ({ patients }) => {
  return (
    <div>
      <h2>Patient List</h2>
      <ul>
        {patients.map((patient, index) => (
          <li key={index}>
            {patient.name} - {patient.stage} - {patient.treatment}
          </li>
        ))}
      </ul>
    </div>
  );
};

export default PatientList;
