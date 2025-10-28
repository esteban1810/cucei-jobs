import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function Index() {
  const { jobs } = usePage().props;

  return (
    <div className="container mx-auto p-6">
      <h1 className="text-2xl font-bold mb-4">Vacantes</h1>
      <div className="space-y-4">
        {jobs.data.map(job => (
          <div key={job.id} className="border rounded p-4">
            <h2 className="text-xl font-semibold">{job.title}</h2>
            <p className="text-sm text-gray-600">{job.company?.name} • {job.location || 'Ubicación no especificada'}</p>
            <div className="mt-2">
              <Link className="text-blue-600 hover:underline" href={`/jobs/${job.id}`}>Ver detalle</Link>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}