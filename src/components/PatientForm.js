import React from "react";
import { useForm } from "react-hook-form";

const PatientForm = () => {
  const { register, handleSubmit, reset } = useForm();

  return (
    <form>
      <center>
        <label>Patient Name:</label>
        <input {...register("name")} name="name" required />
        <br />
        <label>Address:</label>
        <input {...register("address")} name="address" required />
        <br />
        <label>Phone Number:</label>
        <input type="number" {...register("phone")} name="phone" required />
        <br />
        <label>Age of Disease Diagnosis:</label>
        <input type="number" {...register("age")} name="age" required />
        <br />
        <label>Additional Notes:</label>
        <textarea {...register("notes")} name="notes" />
        <br />
        <button type="submit">Submit</button>
      </center>
    </form>
  );
};

export default PatientForm;
