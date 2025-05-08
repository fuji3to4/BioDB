import React, { useState, useEffect } from 'react';

import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table"

import { Button } from "@/components/ui/button"

import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from "@/components/ui/popover"




interface DataItems {
  pdbID: string;
  method: string;
  resolution: number;
  class: string;
  name: string;
  organism: string;
}

interface DetailItems {
  pdbID: string;
  method: string;
  resolution: number;
  chain: string;
  positions: string
  deposited: string
  class: string;
  name: string;
  organism: string;
  url: string;
  len: string;
}




export function ResultTable({ data }: { data: DataItems[] }) {
  const [selectedID, setSelectedID] = useState<string>('');
  const [details, setDetails] = useState<DetailItems>();

  useEffect(() => {
    const handleDetail = async (id: string) => {
      try {
        const response = await fetch(`http://localhost/api/detail.php?id=${id}`);
        const data = await response.json();
        if (data.status === 'success') {
          setDetails(data.data);
          console.log('Search results:', data.data);
        }
      } catch (error) {
        console.error('Error fetching search results:', error);
      }
    };

    handleDetail(selectedID);
  }, [selectedID]);

  return (
    <Table>
      <TableHeader>
        <TableRow>
          <TableHead >PDB ID</TableHead>
          <TableHead >Method</TableHead>
          <TableHead >Resolution</TableHead>
          <TableHead >Class</TableHead>
          <TableHead >Protein Name</TableHead>
          <TableHead >Organism</TableHead>
        </TableRow>
      </TableHeader>
      <TableBody>
        {data.map((item, index) => (
          <TableRow key={index}>
            {/* pdbIDのcellだけ、popoverするように仕込んでます。
            1. Button clickでsetectedIDにpdbIDがセットされて
            2. useEffectでapiにアクセスして情報を得ています。 */}
            <TableCell>
              <Popover>
                <PopoverTrigger asChild>
                  <Button
                    variant="link"
                    onClick={() => setSelectedID(item.pdbID)}
                  >
                    {item.pdbID}
                  </Button>
                </PopoverTrigger>
                <PopoverContent className="w-160" side="right">
                  {details ? (
                    <div className="flex items-start gap-4">
                      <div className="w-80 flex-shrink-0">
                        <img src={`./pic/${details.pdbID.toLowerCase()}.jpeg`} alt={details.pdbID} className="w-full h-auto rounded" />

                      </div>

                      <div className="flex-1">
                        <h3 className="font-bold text-lg">{details.pdbID}</h3>
                        <p>Method: {details.method}</p>
                        <p>Resolution: {details.resolution}</p>
                        <p>Chain: {details.chain}</p>
                        <p>Positions: {details.positions}</p>
                        <p>Deposited: {details.deposited}</p>
                        <p>Class: {details.class}</p>
                        <p>Protein Name: {details.name}</p>
                        <p>Organism: {details.organism}</p>
                        <p>Length: {details.len}</p>
                        <a href={details.url} target="_blank" rel="noopener noreferrer" className="text-blue-500 hover:underline">
                          View on PDB
                        </a>
                      </div>
                    </div>
                  ) : (
                    <p>Loading...</p>
                  )}
                </PopoverContent>
              </Popover>
            </TableCell>
            <TableCell>{item.method}</TableCell>
            <TableCell>{item.resolution}</TableCell>
            <TableCell>{item.class}</TableCell>
            <TableCell>{item.name}</TableCell>
            <TableCell>{item.organism}</TableCell>
          </TableRow>
        ))}
      </TableBody>
    </Table>

  );
}

