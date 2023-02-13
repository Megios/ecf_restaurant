import axios from "axios";
import React, { useState } from "react";
import styled from "styled-components";

const RemoveSousCat = (props) => {
  const [toast, setToast] = useState("");
  const [sup, setSup] = useState(false);

  const handleCancel = (e) => {
    setSup(false);
  };
  const handleOuvre = (e) => {
    setSup(true);
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    let formulaire = {
      Id: props.id,
    };
    axios
      .post("/removeSousCat", formulaire)
      .then(function (response) {
        console.log(response.data.Message);
        setSup(false);
        window.location.reload(false);
      })
      .catch(function (error) {
        console.log(error);
        setToast(false);
      });
  };

  return (
    <Wrapper>
      {sup === true ? (
        <div id="actif">
          <h2>Etes-vous sur de vouloir supprimer cette Catégories?</h2>
          <p>Cette action est irrévocable et supprimera toutes les produits associés</p>
          <button className="Suppression" type="submit" onClick={handleSubmit}>
            Oui
          </button>
          <button className="Annulation" onClick={handleCancel}>Annuler</button>
          {toast === "" ? null : <p>une erreur est survenu</p>}
        </div>
      ) : (
        <button onClick={handleOuvre}>Supprimer</button>
      )}
    </Wrapper>
  );
};

const Wrapper = styled.div`
position: relative;
#actif {
  position: absolute;
  z-index: 2;
  display: block;
  right: 0%;
  top: -2%;
  width:300px;
  background: #B6AC97;
  border: 2px solid black;
  .Suppression{
    background: white;
    padding: 5px 10px;
    border-radius: 15px;
    margin:10px;
  }
  .Annulation{
    background: white;
    padding: 5px 10px;
    border-radius: 15px;
    margin:10px;

  }
}
`;

export default RemoveSousCat;
