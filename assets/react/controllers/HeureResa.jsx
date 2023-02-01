import React from "react";
import styled from "styled-components";

const HeureResa = (props) => {
  const day = props.day;
  const handleHeureInput = (e) => {
    props.setHeureResa(e.target.value);
    console.log("change checkbox");
  };
  return (
    <Wrapper>
      <input
        type="radio"
        name="horaires"
        id={day}
        value={day}
        onChange={handleHeureInput}
      />
      <label htmlFor={day}>{day}</label>
    </Wrapper>
  );
};
const Wrapper = styled.div`
  margin: 9px 0;
  label {
    border: 1px solid #392c1e;
    background: #906427;
    cursor: pointer;
    color: white;
    padding: 9px 16px;
  }
  input[type="radio"] {
    display: none;
  }
  input[type="radio"]:checked + label {
    background: #b6ac97;
    border: 1px solid #392c1e;
    box-shadow: inset 2px 4px 6px rgba(0, 0, 0, 0.25);
  }
`;
export default HeureResa;
